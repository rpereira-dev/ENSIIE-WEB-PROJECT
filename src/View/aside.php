<?php

namespace View\Aside;

/** affiche les informations sur le profil du joueur */
function afficher_profil($user) {
?>
        <script type="text/javascript">
            /** déconnectes l'utilisateur  */
            function disconnect() {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", 'disconnect.php', true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        if (xhr.status == 200) {
                            toast("Déconnecté(e). Vous allez être redirigé(e).", 2);
                            setTimeout(function () { window.location.replace(window.location.href); }, 1000);
                        } else {
                            toast("Une erreur innatendue a eu lieu", 0);
                        }
                    }
                }
                xhr.send();
            }
        </script>

        <div class="button" style="margin-top: 1.5rem;">
            <div class="button_text" onclick="disconnect();">Se déconnecter</div>
        </div>

<?php
}

/** affiche les formulaires de connections / enregistrement */
function afficher_champs() {
?>
            <!-- formulaire d'enregistrement -->
            <div id="inscription_form" class="aside-login-form">
                <!-- addresse mail -->
                <div id="emailID" class="prompt">
                    <i class="prompt-logo fa fa-envelope navbar-search-logo"></i>
                    <input  id="input_emailID"
                            name="email"
                            class="prompt-input"
                            type="text"
                            placeholder="Adresse mail..."
                            oninput="return onInput(event);"
                            onkeypress="return onPressed(event);"
                    />
                </div>
                
                <!-- champ pseudo -->
                <div id="pseudoID" class="prompt">
                    <i class="prompt-logo fa fa-user navbar-search-logo"></i>
                    <input  id="input_pseudoID"
                            name="pseudo"
                            class="prompt-input"
                            type="text"
                            placeholder="Pseudo..."
                            oninput="return onInput(event);"
                    />
                </div>

                <!-- champ mot de passe -->
                <div id="passID" class="prompt">
                    <i class="prompt-logo fa fa-lock navbar-search-logo"></i>
                    <input  id="input_passID"
                            name="pass"
                            class="prompt-input"
                            type="password"
                            placeholder="Mot de passe..."
                            onkeypress="return onPressed(event);"
                            oninput="return onInput(event);"
                    />
                </div>

                <!-- champ confirmation de mot de passe -->
                <div id="confirmPassID" class="prompt">
                    <i class="prompt-logo fa fa-lock navbar-search-logo"></i>
                    <input  id="input_confirmPassID"
                            class="prompt-input"
                            type="password"
                            placeholder="Confirmer..."
                            onkeypress="return onPressed(event);"
                            oninput="return onInput(event);"
                    />
                </div>

                <!-- le captcha -->
                <!--<div id="captchaID" class="g-recaptcha aside-captcha" data-sitekey="6LfSvVEUAAAAAI2FQTEC8rBUcm3DybzVmf8g44t_"></div>-->
                <div id="captchaID" class="g-recaptcha aside-captcha"></div>
                <script type="text/javascript">
                    var onloadCallback = function() {
                        grecaptcha.render('captchaID', {
                          'sitekey' : '6LfSvVEUAAAAAI2FQTEC8rBUcm3DybzVmf8g44t_'
                        });
                    };
                </script>

                <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>


                <!-- se connecter / s'enregistrer -->
                <div class="aside-login-labels">
                    <a class="label label-button" onclick="onConnectClick();">Se connecter</a>
                    <span class="label"> | </span>
                    <a class="label label-button" onclick="onRegisterClick();">S'enregistrer</a>
                </div>
            </div>

        
            <!-- script de coulissement -->
            <script>

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
                    if (isRegistering()) {
                        validateInputs();
                    }
                }

                /** enregistre l'utilisateur avec les informations actuellement entrées */
                function register() {
                    if (!validates["input_emailID"]()) {
                        toast("Veuillez entrer une adresse mail valide.", 0);
                        return ;
                    }

                    if (!validates["input_pseudoID"]()) {
                        toast("Veuillez entrer un pseudo valide.", 0);
                        return ;
                    }

                    if (!validates["input_passID"]()) {
                        toast("Veuillez entrer un mot de passe valide.", 0);
                        return ;
                    }


                    var response = grecaptcha.getResponse();
                    if (response == null || response.length == 0) {
                        toast("Veuillez prouvez que vous n'êtes pas un robot.", 0);
                        return ;
                    }


                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", 'register.php', true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == XMLHttpRequest.DONE) {
                            if (xhr.status == 200) {
                                toast("Enregistré(e). Vous pouvez maintenant vous connecter.", 2);
                                setRegistrationVisibility(false);
                            } else {
                                toast("Erreur dans l'enregistrement: " + xhr.response, 0);
                            }
                        }
                    }
                    xhr.send(   "email=" + document.getElementById("input_emailID").value
                                + "&pseudo=" + document.getElementById("input_pseudoID").value
                                + "&pass=" + document.getElementById("input_passID").value
                                + "&g-recaptcha=" + response
                            );
                }

                /** connectes l'utilisateur avec les informations actuellement entrées dans les champs */
                function connect() {

                    var email = document.getElementById("input_emailID").value;
                    var pass =  document.getElementById("input_passID").value;
                    if (!validates["input_emailID"]() || !validates["input_passID"]()) {
                        toast("Les identifiants de connections sont invalides.", 0);
                        return ;
                    }
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", 'connect.php', true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == XMLHttpRequest.DONE) {
                            if (xhr.status == 200) {
                                toast("Connecté(e). Vous allez être redirigé(e).", 2);
                                setTimeout(function () { window.location.replace(window.location.href); }, 1000);
                            } else {
                                toast("Erreur de connection: " + xhr.response, 0);
                            }
                        }
                    }
                    xhr.send("email=" + email + "&pass=" + pass);
                }

                /** lorsque l'utilisateur appuie sur une touche */
                function onPressed(event) {
                    /* si la touche entrée */
                    if (event.keyCode == 13) {
                        /* si l'utilisateur s'enregistre */
                        if (isRegistering()) {
                            register();
                        } else {
                            connect();
                        }
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
        afficher_champs();
    } else {
        afficher_profil($user);
    }
    afficher_discord($user);
?>
        </section>
<?php
}
?>
