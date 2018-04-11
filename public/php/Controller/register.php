<?php

/* recupere la session */
session_start();

/* recupere l'utilisateur */
include '../Model/Utilisateur.php';
$user = Utilisateur\Utilisateur::instance();

/* vérifie que les entrées existent */
if (isset($_POST['email']) && isset($_POST['pseudo']) && isset($_POST['pass'])) {
    /* la bdd */
    include 'bdd.php';
    $db = getDB(getenv('DB_USER'), getenv('DB_PASSWORD'));
    
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
    }
}

?>