<?php
header("Content-Type: text/html; charset=utf8");
include("index.php");
/*include("db.php");*/

$email=$_POST['email']; 

//recuperer la valeur saisie dans le champ "mdp" 
$mdp = $_POST['mdp']; 


if(!isset($_POST['connecter']&&!isset($_POST['ensegistrer'])){
        exit("erreur");
    }

    else if (isset($_POST['connecter']){

 		if ($email && $mdp){
 				$sql = "select email,password from joueur where username = '$name' and password='$passowrd'";
 				$result = mysql_query($sql);
 			    $rows=mysql_num_rows($result);
 			   	if($rows){//0 false 1 true
                   /*TO DO


                   */
                   exit;
                 }else{
                echo "email ou mot de passe n'est pas correct...";
                 }
         else{
         		echo "email ou mot de passe ne peut pas etre vide...";
         }


    }  else {
		$mdp2 = $_POST['cmdp']; 
		$psd=$_POST['psd']; 
		if($email && $mdp &&$mdp2&&$psd){

			if( $mdp!= $mdp2 ){

				echo "les mots de passe ne sont pas pareil..."

			}

				$sql="insert into joueur(email,pseudo,password) values ('$email','$psd','$mdp')";
				if (!$reslut){
       					 echo "ERROR";
   				}else{
       					 echo "Vous avez bien ensegistre!!!";
   				}

    

    mysql_close($con);

		}else{

			echo "completez la tableau ,s'il vous plait...";

		}


    }



?>