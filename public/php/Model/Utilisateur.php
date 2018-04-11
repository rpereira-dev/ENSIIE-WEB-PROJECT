<?php

/* namespaces */
namespace Utilisateur;
use PDO;

/* import */
include_once 'Joueur.php';

/**
 *  Représente l'utilisateur sur le site.
 *  Une seule instance de cette classe peut existe à la fois.
 *  @see
 */

class Utilisateur {
    
    /** l'unique instance Utilisateur */
    private static $instance = NULL;
    
    /**
     * @return Utilisateur l'instance correspondant à l'utilisateur du site
     */
    public static function instance() {
        if (Utilisateur::$instance == NULL) {
            if (isset($_SESSION['utilisateur'])) {            
                Utilisateur::$instance = unserialize($_SESSION['utilisateur']);
            } else {
                Utilisateur::$instance = new Utilisateur();
                $_SESSION['utilisateur'] = serialize(Utilisateur::$instance);
            }
        }
        return (Utilisateur::$instance);
    }
    
    /** le joueur qui correspond à l'utilisateur (NULL si non connecté) */
    private $joueur;
    
    /** constructeur */
    public function __construct() {
        $joueur = NULL;
    }

    /**
     *  Enregistres l'utilisateur dans la base de donnée
     * @param \PDO $db
     * @param string $mail
     * @param string $pseudo
     * @param string $pass
     * @return true si l'enregistrement a pu avoir lieu, false sinon
     */
    public function register($db, $mail, $pseudo, $pass) {
        /* prépares la base de données */
        $stmt = $db->prepare("INSERT INTO joueur (email, pseudo, pass) VALUES (:email, :pseudo, :pass)");
        /* protège des injections sql */
        $pass = $this->hashPass($pass);
        $stmt->bindParam(':email',  $mail,      PDO::PARAM_STR);
        $stmt->bindParam(':pseudo', $pseudo,    PDO::PARAM_STR);        
        $stmt->bindParam(':pass',   $pass,      PDO::PARAM_STR);
        
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
     * @param PDO $db
     * @param string $mail
     * @param string $pass
     * @return $this->joueur Si l'utilisateur a pu se connecter, NULL sinon
     * @see http://www.phptherightway.com/#databases_interacting
     * @see http://php.net/manual/fr/filter.filters.sanitize.php
     * @see http://php.net/manual/fr/pdostatement.bindparam.php
     */
    public function connectAs($db, $mail, $pass) {
        /* prépares la base de données */
        $stmt = $db->prepare('SELECT * FROM joueur WHERE email = :email');
        /* protège des injections sql */
        $stmt->bindParam(':email', $mail, PDO::PARAM_STR);
        
        /* execute la requete sécurisé */
        $stmt->execute();
        if ($stmt->rowCount() == 0) {
            /* pas d'utilisateur pour cette adresse mail */
            return (false);
        }
        /* renvoie un tableau associatif de l'entrée dans la table */
        $entry = $stmt->fetch();
 
        /* si le mot de passe est juste */
        if (password_verify($pass, $entry['pass'])) {
            $this->joueur = new Joueur($entry['id'], $entry['email'], $entry['pseudo']);
            return ($this->joueur);
        }
        return (NULL);
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