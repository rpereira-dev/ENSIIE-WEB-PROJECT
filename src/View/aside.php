<?php

function afficher_aside() {
?>

        <!-- barre de navigation à droite -->
        <section class="aside">

            <!-- formulaire de connection -->
            <form id="connection_form" class="aside-login-form" action="./connect.php" method="POST">
                <!-- addresse mail -->
                <div class="prompt">
                    <i class="prompt-logo fa fa-envelope navbar-search-logo"></i>
                    <input name="email" class="prompt-input" type="text" placeholder="Adresse mail..."/>
                </div>
                
                <!-- champ mot de passe -->
                <div class="prompt">
                    <i class="prompt-logo fa fa-lock navbar-search-logo"></i>
                    <input name="pass" class="prompt-input" type="password" placeholder="Mot de passe..."/>
                </div>
                
                <!--  bouton pour envoyer le formulaire -->
              	<input type="submit"/>
            </form>
            
            <!-- formulaire d'enregistrement -->
            <form id="inscription_form" class="aside-login-form" action="./register.php" method="POST">
                <!-- addresse mail -->
                <div class="prompt">
                    <i class="prompt-logo fa fa-envelope navbar-search-logo"></i>
                    <input name="email" class="prompt-input" type="text" placeholder="Adresse mail..."/>
                </div>
                
                <!-- champ pseudo -->
                <div class="prompt">
                    <i class="prompt-logo fa fa-user navbar-search-logo"></i>
                    <input name="pseudo" class="prompt-input" type="text" placeholder="Pseudo..."/>
                </div>

                <!-- champ mot de passe -->
                <div class="prompt">
                    <i class="prompt-logo fa fa-lock navbar-search-logo"></i>
                    <input name="pass" class="prompt-input" type="password" placeholder="Mot de passe..."/>
                </div>

                <!-- champ confirmation de mot de passe -->
                <div class="prompt">
                    <i class="prompt-logo fa fa-lock navbar-search-logo"></i>
                    <input class="prompt-input" type="password" placeholder="Confirmer..."/>
                </div>

				<!-- le captcha -->
                <div id="captcha" class="g-recaptcha aside-captcha" data-sitekey="6LfSvVEUAAAAAI2FQTEC8rBUcm3DybzVmf8g44t_"></div>

                <!--  bouton pour envoyer le formulaire -->
              	<input type="submit"/>
            </form>
            
            <!-- se connecter / s'enregistrer -->
            <div class="aside-login-labels">
                <a class="label label-button" onclick="switchView(false);">Se connecter</a>
                <span class="label"> | </span>
                <a class="label label-button" onclick="switchView(true);">S'enregistrer</a>
            </div>

            <!-- script de coulissement -->
            <script>

                function switchView(register) {
                    if (register) {
                        document.getElementById("connection_form").style.display  = "none";
                        document.getElementById("inscription_form").style.display = "";
                    } else {
                        document.getElementById("connection_form").style.display  = "";
                        document.getElementById("inscription_form").style.display = "none";
                    }
                }
                switchView(false);
            </script>

            <!-- serveur discord -->
            <!--<embed class="aside-discord" src="https://widgetbot.io/embed/432533096609480704/432533096609480706/1001/?lang=fr" />
            <script src="https://crate.widgetbot.io/v2" defer async data-cfasync="false">
                var crate = new Crate({ "server" : "432533096609480704",
                            "channel" : "432533096609480706",
                            "options" : "1001",
                            "language":"fr"
                        });
                crate.message('`2 seconds`', 2000);
            </script>-->
            <!--
            <script src="https://crate.widgetbot.io/v2" defer async data-cfasync="false">new Crate({"server":"432533096609480704","channel":"432533096609480706"})</script>      
            -->
            
                <iframe
                    class="aside-discord"
                    src="https://discordapp.com/widget?id=432533096609480704&theme=dark"
                    allowtransparency="true"
                    frameborder="0">
                </iframe>
            
               <!--
                <script type="text/javascript" src="//cdn.jsdelivr.net/discord-widget/latest/discord-widget.min.js"></script>
                <script type="text/javascript">
                    discordWidget.init({
                        serverId: '432533096609480704',
                        title: 'Rejoignez notre discord',
                        join: true,
                        alphabetical: false,
                        theme: 'dark',
                        showAllUsers: true,
                        allUsersDefaultState: true
                    });
                    discordWidget.render();
                </script>
            -->

        </section>
<?php
}

?>