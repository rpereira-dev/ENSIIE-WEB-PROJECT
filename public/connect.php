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
if (isset($_POST['email']) && isset($_POST['pass'])) {
    /* la bdd */
    $db = $bdd->getConnection(getenv('DB_USER'));
    
    if ($db != NULL) {
        /* verifie la validité des entrées (injections sql ...) */
        $mail = filter_input(INPUT_POST, 'email',   FILTER_SANITIZE_EMAIL);
        $pass = filter_input(INPUT_POST, 'pass',    FILTER_SANITIZE_STRING);

        /* on connecte l'utilisateur */
        if ($user->connectAs($db, $mail, $pass)) {
            echo "Vous etes connecté";
        } else {
            echo "Erreur d'identification";
        }
    } else {
        echo "Erreur d'acces à la bdd";
    }
}

?>