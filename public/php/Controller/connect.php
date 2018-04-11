<?php

/* recupere la session */
session_start();

/* recupere l'utilisateur */
include '../Model/Utilisateur.php';
$user = Utilisateur\Utilisateur::instance();

/* vérifie que les entrées existent */
if (isset($_POST['email']) && isset($_POST['pass'])) {
    /* la bdd */
    include 'bdd.php';
    $db = getDB(getenv('DB_USER'), getenv('DB_PASSWORD'));
    
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
    }
}

?>