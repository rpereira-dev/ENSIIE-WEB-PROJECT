<?php

namespace Model;

use PDO;
use PDOException;


/* import */
require_once('BDD.php');
require_once('Joueur.php');

/**
 *  Représente l'utilisateur sur le site.
 */

class Utilisateur {
    
    /** l'unique instance Utilisateur */
    private static $instance = NULL;
    
    /**
     * @return Utilisateur l'instance correspondant à l'utilisateur du site
     */
    public static function instance() {
        if (Utilisateur::$instance == NULL) {
            Utilisateur::$instance = new Utilisateur();
            Utilisateur::$instance->loadSession();
        }
        return (Utilisateur::$instance);
    }

    /** le joueur qui correspond à l'utilisateur (NULL si non connecté) */
    private $joueur;
    
    /** constructeur */
    private function __construct() {
        $joueur = NULL;
    }

    /** @internal : export l'utilisateur vers la variable session */
    private function saveSession() {
        if ($this->joueur == NULL) {
            unset($_SESSION['joueur']);
        } else {
            $_SESSION['joueur'] = serialize($this->joueur);
        }
    }


    /** @internal : charges l'utilisateur à partir de sa session */
    private function loadSession() {
        $this->joueur = isset($_SESSION['joueur']) ? unserialize($_SESSION['joueur']) : NULL;
    }

    /**
     *  Enregistres l'utilisateur dans la base de donnée
     * @param \BDD $bdd
     * @param string $mail
     * @param string $pseudo
     * @param string $pass
     * @return Le retour de la requete sql d'insertion
     * @throws PDOException : si une erreur a lieu
     */
    public function register($bdd, $mail, $pseudo, $pass) {
        /* on recupere la connection à la pdo */
        $pdo = $bdd->getConnection("ulc");
        if ($pdo == NULL) {
            throw new PDOException("Connection error");
        }

        /* prépares la base de données */
        $stmt = $pdo->prepare("INSERT INTO joueur (mail, pseudo, pass) VALUES (:mail, :pseudo, :pass)");
        /* protège des injections sql */
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
        $stmt->bindParam(':mail',   $mail,          PDO::PARAM_STR);
        $stmt->bindParam(':pseudo', $pseudo,        PDO::PARAM_STR);        
        $stmt->bindParam(':pass',   $hashedPass,    PDO::PARAM_STR);
        
        /* execute la requete sécurisé */
        return ($stmt->execute());
    }
    
    /**
     *  Modifie le mot de passe de l'utilisateur
     * @param \BDD $bdd
     * @param string $mail
     * @param string $pass
     * @return Le retour de la requete sql d'update
     * @throws PDOException : si une erreur a lieu
     */
    public function modifyPassword($bdd, $mail, $pass) {
        /* on recupere la connection à la pdo */
        $pdo = $bdd->getConnection("ulc");
        if ($pdo == NULL) {
            throw new PDOException("Connection error");
        }
        $stmt = $pdo->prepare("UPDATE joueur SET pass=:pass WHERE mail=:mail");

        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
        $stmt->bindParam(':pass', $hashedPass, PDO::PARAM_STR);

        return ($stmt->execute());
    }

    /**
     *  Vérifie que le token passé en paramètre, pour l'adresse mail
     * de l'utilisateur associé est valide.
     * @param \BDD $bdd
     * @param string $mail
     * @param string $token
     * @return TRUE si le token est valid, FALSE sinon
     * @throws PDOException : si une erreur a lieu
     */
    public function isTokenValid($bdd, $mail, $token) {
        $pdo  = $bdd->getConnection("ulc");
        if ($pdo == NULL) {
            throw new PDOException("Connection error");
        }
        $stmt = $pdo->prepare("SELECT * FROM reset_token
                                    JOIN joueur ON joueur_id=id
                                        WHERE mail=:mail AND token=:token
                                            AND (NOW() BETWEEN date_generation AND date_generation + '15 minutes'::interval)
                            ");
        $stmt->bindParam(':mail',  $mail, PDO::PARAM_STR);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        return ($stmt->rowCount() == 1);
    }

    /**
     * Connecte l'utilisateur sur le site.
     * Exemple d'utilisation:
     * <pre> <code>
     *  $mail = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
     *  $pass = filter_input(INPUT_POST, 'pass',  FILTER_SANITIZE_STRING);
     *  if ($utilisateur->connectAs($db, $mail, $pass)) {
     *      print("Vous etes connecté");
     *  } else {
     *      print("Erreur d'identification");
     *  }
     * </code> </pre>
     *  
     *  @param PDO $db
     *  @param string $mail
     *  @param string $pass
     *  @return $this->joueur Si l'utilisateur a pu se connecter
     *  @throws PDOException : si une erreur a lieu
     *  @seeall http://www.phptherightway.com/#databases_interacting
     *  @seeall http://php.net/manual/fr/filter.filters.sanitize.php
     *  @seeall http://php.net/manual/fr/pdostatement.bindparam.php
     */
    public function connectAs($bdd, $mail, $pass) {
        /* on recupere la connection à la pdo */
        $pdo = $bdd->getConnection("ulc");
        if ($pdo == NULL) {
            throw new PDOException("Connection error");
        }
        $stmt = $pdo->prepare('SELECT * FROM joueur WHERE mail = :mail');
        $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
        
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            /* pas d'utilisateur pour cette adresse mail */
            throw new PDOException("Wrong mail");
        }
        /* renvoie un tableau associatif de l'entrée dans la table */
        $entry = $stmt->fetch();
 
        /* si le mot de passe est juste */
        if (password_verify($pass, $entry['pass'])) {
            $this->joueur = new Joueur($entry['id'], $entry['mail'], $entry['pseudo'], $entry['ecole']);
            $this->saveSession();
            return ($this->joueur);
        }
        return (NULL);
    }

    /**
     *  @return $this->joueur le joueur
     */
    public function asJoueur() {
        return ($this->joueur);
    }

    /**
     *  @return true si l'utilisateur est connecté, false sinon
     */
    public function isConnected() {
        return ($this->asJoueur() != NULL);
    }
    
}



?>