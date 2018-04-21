<?php

namespace View\Header;

function afficher() {
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- UTF-8 (accents ...) -->
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <!-- on s'assure que le rendu graphique et les entrées soit correctes sur mobile -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- font awesome icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- css -->
        <link rel="stylesheet" type="text/css" href="./css/aside.css">
        <link rel="stylesheet" type="text/css" href="./css/main.css">
        <link rel="stylesheet" type="text/css" href="./css/navbar.css">
        <link rel="stylesheet" type="text/css" href="./css/page.css">
        <link rel="stylesheet" type="text/css" href="./css/sidebar.css">
        <link rel="stylesheet" type="text/css" href="./css/toastbar.css">

        <!-- reCaptcha -->
        <script type="text/javascript" src='https://www.google.com/recaptcha/api.js'></script>

        <!-- import du fond animé -->
       <script type="text/javascript" src="https://unpkg.com/delaunator@2.0.0/delaunator.min.js"></script>
       <!--<script type="text/javascript" src="./js/background.js"></script>-->

       <!-- fonction de redirection -->
       <script type="text/javascript">
            function redirectToPage(page) {
                window.location.replace("?page=" + page);
            }
        </script>

    </head>


    <body onload="onPageLoaded()">
<?php
}

?>