<?php

/**
 *  Génère un token de réinitialisation de mot de passe, et envoie un mail
 */

/* include path */
require '../../../../../../vendor/autoload.php'; 

/* import */
use Model\BDD;
use Model\Utilisateur;
use Model\Utils;

/* recupere la session */
session_start();

$user = Utilisateur::instance();

//si le joueur n'est pas connecté
if (!$user->isConnected()) {
    http_response_code(400);
    echo 'Non connecté.';
//si la requete est invalide
} else {
    http_response_code(200);
    $token = Utils::random_str(32);
    $_SESSION['password-token'] = $token;

    $mail 		= $user->asJoueur()->getMail();
    $subject 	= "ULC : Réinitialisation mot de passe";
    $content	= "Pour réintialiser votre mot de passe, merci de cliquer sur le lien suivant: http://localhost:8080/api/user/account/password/reset/reset.php?token=" . $token;
     $headers = 	'From: webmaster@example.com' . "\r\n" .
			     'Reply-To: webmaster@example.com' . "\r\n" .
			     'X-Mailer: PHP/' . phpversion();
    echo "<h1>${mail}</h1>";
    echo "<h2>${subject}</h2>";
    echo "<h3>${content}</h3>";
    echo "<h4>${headers}</h4>";
    mail($mail, $subject, $content, $headers);
}

?>
