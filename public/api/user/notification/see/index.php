<?php

/**
 *  Marques toutes les notifications comme 'vu' de l'utilisateur dans la session 
 */


/* include path */
require '../../../../../vendor/autoload.php'; 

/* on charge la session */
session_start();

/* on recupere le joueur */
$user = \Model\Utilisateur::instance();
if (!$user->isConnected()) {
    http_response_code(401);
    echo "Non connecté";
    return ;
}

/* on recupere la connection à la pdo */
$bdd = \Model\BDD::instance();
$pdo = $bdd->getConnection("ulc");
if ($pdo == NULL) {
    throw new PDOException("Connection error");
}

/* prépares la base de données */
$stmt = $pdo->prepare("UPDATE notification SET status = 'seen' WHERE joueur_id = :joueur_id");
/* protège des injections sql */
$id = $user->asJoueur()->getUUID();
$stmt->bindParam(':joueur_id', $id, PDO::PARAM_INT);

/* execute la requete sécurisé */
$stmt->execute();

echo 'OK';
http_response_code(200);

?>