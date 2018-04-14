<?php

namespace View\Aside;

function afficher_champs($user) {
?>
            <!-- formulaire d'enregistrement -->
            <div id="inscription_form" class="aside-login-form">
                <!-- addresse mail -->
                <div id="emailID" class="prompt">
                    <i class="prompt-logo fa fa-envelope navbar-search-logo"></i>
                    <input id="input_emailID" oninput="return onInput(event);" name="email" class="prompt-input" type="text" placeholder="Adresse mail..."/>
                </div>
                
                <!-- champ pseudo -->
                <div id="pseudoID" class="prompt">
                    <i class="prompt-logo fa fa-user navbar-search-logo"></i>
                    <input id="input_pseudoID" oninput="return onInput(event);" name="pseudo" class="prompt-input" type="text" placeholder="Pseudo..."/>
                </div>

                <!-- champ mot de passe -->
                <div id="passID" class="prompt">
                    <i class="prompt-logo fa fa-lock navbar-search-logo"></i>
                    <input id="input_passID" oninput="return onInput(event);" name="pass" class="prompt-input" type="password" placeholder="Mot de passe..."/>
                </div>

                <!-- champ confirmation de mot de passe -->
                <div id="confirmPassID" class="prompt">
                    <i class="prompt-logo fa fa-lock navbar-search-logo"></i>
                    <input id="input_confirmPassID" oninput="return onInput(event);" class="prompt-input" type="password" placeholder="Confirmer..."/>
                </div>

                <!-- le captcha -->
                <div id="captchaID" class="g-recaptcha aside-captcha" data-sitekey="6LfSvVEUAAAAAI2FQTEC8rBUcm3DybzVmf8g44t_"></div>
            </form>
            
            <!-- se connecter / s'enregistrer -->
            <div class="aside-login-labels">
                <a class="label label-button" onclick="onConnectClick();">Se connecter</a>
                <span class="label"> | </span>
                <a class="label label-button" onclick="onRegisterClick();">S'enregistrer</a>
            </div>

            <!-- script de coulissement -->
            <script>

                /** enregistre l'utilisateur avec les informations actuellement entrées */
                function register() {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", 'register.php', true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {//Call a function when the state changes.
                        if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {

                        }
                        console.log(xhr.status);
                        console.log(xhr.response);
                    }
                    xhr.send(   "email=" + document.getElementById("input_emailID").value
                                + "&pseudo=" + document.getElementById("input_pseudoID").value
                                + "&pass=" + document.getElementById("input_passID").value
                            );
                }

                /** connectes l'utilisateur avec les informations actuellement entrées dans les champs */
                function connect() {

                    var email = document.getElementById("input_emailID").value;
                    var pass =  document.getElementById("input_passID").value;
                    if (email.length < 5 || pass.length < 8) {
                        console.log("entree invalide, pas de requete envoyé");
                        return ;
                    }

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", 'connect.php', true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {//Call a function when the state changes.
                        if(xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {

                        }
                        console.log(xhr.status);
                        console.log(xhr.response);
                    }
                    xhr.send("email=" + email + "&pass=" + pass);
                }


                /** renvoie vrai si la vue d'enregistrement est affiché */
                function isRegistering() {
                    return (document.getElementById("pseudoID").style.display == "");
                }

                /** les tests d'entrées */
                var elements  = {};
                var validates = {};

                /* email validation */
                elements["input_emailID"]  = "emailID";
                validates["input_emailID"] = function() {
                    var email = document.getElementById("input_emailID").value;
                    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return re.test(String(email).toLowerCase());
                };

                /* pseudo validation */
                elements["input_pseudoID"]  = "pseudoID";
                validates["input_pseudoID"] = function() {
                    var pseudo = document.getElementById("input_pseudoID").value;
                    return (pseudo.length > 0);
                };

                /* pass validation */
                elements["input_passID"]  = "passID";
                validates["input_passID"] = function() {
                    var pass = document.getElementById("input_passID").value;
                    return (pass.length >= 6);
                };

                /* confirm pass validation */
                elements["input_confirmPassID"]  = "confirmPassID";
                validates["input_confirmPassID"] = function() {
                    var pass        = document.getElementById("input_passID").value;
                    var confirmPass = document.getElementById("input_confirmPassID").value;
                    var confirmPassDiv = document.getElementById("confirmPassID");
                    return (pass == confirmPass && validates["input_passID"]());
                };

                /**
                 *  met à jour le style des éléments en fonction des entrées
                 *  (met en vert quand les mots de passes sont égaux...)
                 */
                 function validateInputs() {
                    for (var elementID in elements) {
                        var divElement = document.getElementById(elements[elementID]);
                        if (validates[elementID]()) {
                            divElement.style.borderColor = "#22FF22";
                        } else if (document.getElementById(elementID).value.length > 0) {
                            divElement.style.borderColor = "#FF2222";
                        } else {
                            divElement.style.borderColor = "";
                        }
                    }
                 }

                /** lorsqu'un touche est appuyé */
                function onInput(event) {
                    /* si la touche entrée */
                    if (event.keyCode == 13) {
                        /* si l'utilisateur s'enregistre */
                        if (isRegistering()) {
                            register();
                        } else {
                            connect();
                        }
                    } else if (isRegistering()) {
                        validateInputs();
                    }
                }

                /** rends visible ou non les champs d'inscriptions */
                function setRegistrationVisibility(visible) {
                    if (visible) {
                        document.getElementById("pseudoID").style.display  = "";
                        document.getElementById("confirmPassID").style.display = "";
                        document.getElementById("captchaID").style.display = "";
                        validateInputs();
                    } else {
                        document.getElementById("pseudoID").style.display  = "none";
                        document.getElementById("confirmPassID").style.display = "none";
                        document.getElementById("captchaID").style.display = "none";
                        for (var elementID in elements) {
                        var divElement = document.getElementById(elements[elementID]);
                            divElement.style.borderColor = "";
                        }
                    }
                }

                /** quand on appuie sur le label 'se connecter' */
                function onConnectClick() {
                    if (isRegistering()) {
                        setRegistrationVisibility(false);
                    } else {
                        connect();
                    }
                }

                /** quand on appuie sur le label 'se connecter' */
                function onRegisterClick() {
                    if (!isRegistering()) {
                        setRegistrationVisibility(true);
                    } else {
                        register();
                    }
                }

                setRegistrationVisibility(false);
            </script>
<?php
}

function afficher_discord($user) {
?>
                <iframe
                    class="aside-discord"
                    src="https://discordapp.com/widget?id=432533096609480704&theme=dark"
                    allowtransparency="true"
                    frameborder="0">
                </iframe>
<?php
}

/**
 *  Fonction principal d'affichage
 *
 *  \Utilisateur $user : l'utilisateur
 */
function afficher($user) {
?>
        <!-- barre de navigation à droite -->
        <section class="aside">
<?php
    if (!$user->isConnected()) {
        afficher_champs($user);
    } else {

    }
    afficher_discord($user);
?>
        </section>
<?php
}
?>
