<?php

/**
 *  @file
 *  @brief Marque toutes les notifications comme ayant été lu
 *  @param :
 *      - COOKIE \a PHPSESSID : le cookie de session PHP \ref api/user/account/connect/index.php
 *      - \a id : l'id de la notification à marquer comme étant lue. \ref api/user/notification/get/index.php
 *  @return
 *      - code reponse:
 *                      - 200 : les notifications ont été marqué comme lu
 *						- 401 : non connecté(e)
 */

///@cond INTERNAL

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

///@endcond INTERNAL

?>