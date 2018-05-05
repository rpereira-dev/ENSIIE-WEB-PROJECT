<?php

/**
 *  Génère un token de réinitialisation de mot de passe, et envoie un mail
 *
 *  Paramètres:
 *      - mail : l'adresse mail associé au compte
 */

/* include path */
require '../../../../../../vendor/autoload.php'; 

/* import */
use Model\BDD;
use Model\Utils;

//si le joueur n'est pas connecté
if (!isset($_GET['mail'])) {
    http_response_code(400);
    echo "Pas d'adresse mail";
//crée un token de reinitialisation
} else {
    http_response_code(200);
    $mail = $_GET['mail'];
    $token = Utils::random_str(32);
    $bdd = BDD::instance();
    try {
        $pdo = $bdd->getConnection("ulc");

        /* insert or update */
        $stmt = $pdo->prepare(
                    "WITH updated AS (" .
                    "UPDATE reset_token SET token=:token FROM joueur WHERE joueur.mail=:mail AND reset_token.joueur_id=joueur.id " .
                    "returning *) " .
                    "INSERT INTO reset_token (joueur_id, token) SELECT joueur.id, :token FROM joueur WHERE NOT EXISTS (SELECT * FROM updated) AND joueur.mail=:mail ;"
                );
        $stmt->bindParam(':token',  $token,     PDO::PARAM_STR);
        $stmt->bindParam(':mail',   $mail,      PDO::PARAM_STR);
        $stmt->execute();

        /* envoie du mail */
        $subject    = "ULC : Réinitialisation mot de passe";
        $content    = "Pour réintialiser votre mot de passe, merci de cliquer sur le lien suivant: http://localhost:8080/api/user/account/password/reset/reset.php?token=" . $token;
        $headers =     'From: webmaster@example.com' . "\r\n" .
                     'Reply-To: webmaster@example.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();
        mail($mail, $subject, $content, $headers);

    } catch (Exception $e) {
        http_response_code(500);
        echo 'Erreur serveur';
    }
}

?>