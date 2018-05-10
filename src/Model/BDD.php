<?php

namespace Model;

use PDO;
use PDOException;


/**
 * Exception levé lorsqu'une connection n'a pas abouti
 */
class BDDConnectionException extends \Exception {
}


/**
 *  Représente la base de donnée
 */
class BDD {

    /** l'unique instance BDD */
    private static $instance = NULL;
    
    /**
     * @return BDD l'instance correspondant à la bdd, toujours non NULL
     */
    public static function instance() {
        if (BDD::$instance == NULL) {
            BDD::$instance = new BDD(getenv('DB_NAME'),
                                        array(
                                            getenv('DB_USER') => getenv('DB_PASSWORD')
                                        )
                                    );
        }
        return (BDD::$instance);
    }
    
    /** la base de données */
    private $dbName;

    /** les utilisateurs */
    private $dbUsers;

    /** les différentes connections aux pdos */
    private $pdos;
    
    /**
     *  Constructeur:
     *
     *  @param  string $dbName :    le nom de la base de donnée
     *  @param  array $dbUsers :    un tableau dont les clefs sont des utilisateurs de la base de donnée,
     *                              et les valeurs leur mot de passe
     */
    public function __construct($dbName, $dbUsers) {
        $this->dbName = $dbName;
        $this->dbUsers = $dbUsers;
        $this->pdos = array();
    }

    /**
     *  Renvoie une connection à la base de données pour l'utilisateur demandé
     *
     *  @param   string $user
     *  @return  \PDO : une connection à la base de données pour l'utilisateur demandé
     *  @throws BDDConnectionException : la connection n'a pas abouti
     */
    public function getConnection($user) {

        /* si une connection est déjà ouverte ... */
        if (isset($this->pdos[$user])) {
            /* on la renvoie */
            return ($this->pdos[$user]);
        }

        /* sinon, si l'utilisateur n'existe pas */
        if (!isset($this->dbUsers[$user])) {
            throw new BDDConnectionException();
        }

        /* sinon, on essaye de se connecter */
        try {
            $password = $this->dbUsers[$user];
            $pdo = new PDO("pgsql:host=postgres user=$user dbname=$this->dbName password=$password");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdos[$user] = $pdo;
            return ($pdo);
        } catch (PDOException $e) {
            throw new BDDConnectionException();
        }
    }
}



?>