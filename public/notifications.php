<?php

/**
 *  Requete GET
 *
 *  Renvoie les notifications de l'utilisateur connecté à une session au format json
 *
 *  Arguments:
 *      - max : nombre maximum de notifications à afficher (les 'max' plus récentes)
 */

/* include path */
require '../vendor/autoload.php'; 

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
$max = 999;
$rows = isset($_GET["max"]) ? $_GET["max"] : $max;
if ($rows < 0) {
    $rows = 0;
} else if ($rows > $max) {
    $rows = $max;
}
$stmt = $pdo->prepare('SELECT * FROM notification WHERE joueur_id = :joueur_id ORDER BY date_envoie DESC, id DESC LIMIT :rows');
/* protège des injections sql */
$id = $user->asJoueur()->getUUID();
$stmt->bindParam(':joueur_id', $id, PDO::PARAM_INT);
$stmt->bindParam(':rows', $rows, PDO::PARAM_INT);

/* execute la requete sécurisé */
$stmt->execute();

/* on enregistre toutes les notifications */
echo '{"notifications":[';
if ($stmt->rowCount() > 0) {
    $entry = $stmt->fetch();
    while ($entry != NULL) {
        echo '{';
            echo '"type":"' . $entry['type'] . '"';
            echo ',';
            echo '"content":"';
            switch ($entry['type']) {
                case 'bienvenue':
                    echo "L'équipe d'ULC vous souhaite la <strong>bienvenue</strong>.";
                    break ;
                case 'invitation':
                    echo "Vous avez reçu une <strong>invitation</strong> pour rejoindre une équipe.";
                    break ;
                default:
                    break;
            }
            echo '",';
            echo '"date":"' . $entry['date_envoie'] . '"';
            echo ',';
            echo '"status":"' . $entry['status'] . '"';
        echo '}';
        $entry = $stmt->fetch();
        if ($entry != NULL) {
            echo ',';
        }
    }
}
echo ']}';
?>