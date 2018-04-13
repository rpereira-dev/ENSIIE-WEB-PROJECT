<?php

/* include path */
set_include_path(get_include_path() . PATH_SEPARATOR . "../src");
require_once("Model/BDD.php");
require_once("Model/Utilisateur.php");

/* recupere la session */
session_start();

$bdd = BDD::instance();
$user = Utilisateur::instance();

/* vérifie que les entrées existent */
if (isset($_POST['email']) && isset($_POST['pseudo']) && isset($_POST['pass'])) {
    /* pdo connection */
    $db = $bdd->getConnection(getenv('DB_USER'));
    if ($db != NULL) {
        /* verifie la validité des entrées (injections sql ...) */
        $mail   = filter_input(INPUT_POST, 'email',     FILTER_SANITIZE_EMAIL);
        $pseudo = filter_input(INPUT_POST, 'pseudo',    FILTER_SANITIZE_STRING);
        $pass   = filter_input(INPUT_POST, 'pass',      FILTER_SANITIZE_STRING);

        /* on enregistre l'utilisateur */
        if ($user->register($db, $mail, $pseudo, $pass)) {
            echo "Vous etes enregistré et connecté!";
        } else {
            echo "Erreur d'enregistrement";
        }
    } else {
            echo "Erreur d'acces à la bdd";
    }
} else {
    echo 'il manque des parametres à la requete POST';
}

?>