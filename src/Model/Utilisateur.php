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
     */
    public function register($bdd, $mail, $pseudo, $pass) {

        /* on recupere la connection à la pdo */
        $pdo = $bdd->getConnection("ulc");

        /* prépares la base de données */
        $stmt = $pdo->prepare("INSERT INTO joueur (email, pseudo, pass) VALUES (:email, :pseudo, :pass)");
        /* protège des injections sql */
        $hashedPass = $this->hashPass($pass);
        $stmt->bindParam(':email',  $mail,          PDO::PARAM_STR);
        $stmt->bindParam(':pseudo', $pseudo,        PDO::PARAM_STR);        
        $stmt->bindParam(':pass',   $hashedPass,    PDO::PARAM_STR);
        
        /* execute la requete sécurisé */
        return ($stmt->execute());
    }
    
    /**
     * Connecte l'utilisateur sur le site.
     * Exemple d'utilisation:
     * <pre> <code>
     * $mail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
     * $pass = filter_input(INPUT_POST, 'pass',  FILTER_SANITIZE_STRING);
     * if ($utilisateur->connectAs($db, $mail, $pass)) {
     *     print("Vous etes connecté");
     * } else {
     *     print("Erreur d'identification");
     * }
     * </code> </pre>
     *  
     *  @param PDO $db
     *  @param string $mail
     *  @param string $pass
     *  @return $this->joueur Si l'utilisateur a pu se connecter
     *  @throws PDOException : si une erreur a lieu
     *  @see http://www.phptherightway.com/#databases_interacting
     *  @see http://php.net/manual/fr/filter.filters.sanitize.php
     *  @see http://php.net/manual/fr/pdostatement.bindparam.php
     */
    public function connectAs($bdd, $mail, $pass) {
        /* on recupere la connection à la pdo */
        $pdo = $bdd->getConnection("ulc");
        if ($pdo == NULL) {
            throw new PDOException("Connection error");
        }

        /* prépares la base de données */
        $stmt = $pdo->prepare('SELECT * FROM joueur WHERE email = :email');
        /* protège des injections sql */
        $stmt->bindParam(':email', $mail, PDO::PARAM_STR);
        
        /* execute la requete sécurisé */
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            /* pas d'utilisateur pour cette adresse mail */
            throw new PDOException("Wrong email");
        }
        /* renvoie un tableau associatif de l'entrée dans la table */
        $entry = $stmt->fetch();
 
        /* si le mot de passe est juste */
        if (password_verify($pass, $entry['pass'])) {
            $this->joueur = new Joueur($entry['id'], $entry['email'], $entry['pseudo'], $entry['ecole']);
            $this->saveSession();
            return ($this->joueur);
        }
        throw new PDOException("Wrong password");
    }
        
    /**
     *  @internal fonction interne qui hash le mot de passe
     *  @see http://php.net/manual/fr/book.password.php
     */
    static private function hashPass($pass) {
        return (password_hash($pass, PASSWORD_DEFAULT));
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
        return ($this->joueur != NULL);
    }
    
}



?>