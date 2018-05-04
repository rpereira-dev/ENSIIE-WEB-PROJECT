<?php

/**
 *  Définit l'image de profil correspondant à l'utilisateur du stie
 *
 *  Paramètres:
 *      - image : l'image
 *
 *  Reponse:
 *      - 200 : si l'image a été upload
 *      - 400 : joueur non connecté
 *		- 401 : requete mal formatté  
 */

/* include path */
require '../../../../../../vendor/autoload.php'; 

use Model\Utilisateur;

session_start();

$user = Utilisateur::instance();

if (!$user->isConnected()) {
    http_response_code(400);
    echo "Non connecté";
    return ;
}

if (!isset($_FILES['image'])
	|| $_FILES['image']['error'] > 0
	|| $_FILES['image']['size'] > 10485760) {
    http_response_code(401);
    echo "la requête est mal formattée";
    return ;
}


//TODO : gérer plus de formats, mais toujours convertir vers '.png'

$info = getimagesize($_FILES['image']['tmp_name']);
if (!$info || $info[2] != IMAGETYPE_PNG) {
    http_response_code(401);
    echo "Le fichier n'est pas une image valide. Le seul format supporté est '.png'";
    return ;
}

http_response_code(200);
$dst = "../get/" . $user->asJoueur()->getPseudo() . ".png";
move_uploaded_file($_FILES["image"]["tmp_name"], $dst);


?>
