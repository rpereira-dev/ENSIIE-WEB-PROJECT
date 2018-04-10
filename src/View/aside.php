<?php

function afficher_aside() {
?>

        <!-- barre de navigation à droite -->
        <section class="aside">

            <form class="aside-login-form">

                <!-- addresse mail -->
                <div id="email" class="prompt">
                    <i class="prompt-logo fa fa-envelope navbar-search-logo"></i>
                    <input class="prompt-input" type="text" placeholder="Adresse mail..."/>
                </div>

                <!-- champ pseudo -->
                <div id="pseudo" class="prompt">
                    <i class="prompt-logo fa fa-user navbar-search-logo"></i>
                    <input class="prompt-input" type="text" placeholder="Pseudo..."/>
                </div>

                <!-- champ mot de passe -->
                <div id="pass" class="prompt">
                    <i class="prompt-logo fa fa-lock navbar-search-logo"></i>
                    <input class="prompt-input" type="password" placeholder="Mot de passe..."/>
                </div>

                <!-- champ confirmation de mot de passe -->
                <div id="pass_confirm" class="prompt">
                    <i class="prompt-logo fa fa-lock navbar-search-logo"></i>
                    <input class="prompt-input" type="password" placeholder="Confirmer..."/>
                </div>

                <div id="captcha" class="g-recaptcha aside-captcha" data-sitekey="6LfSvVEUAAAAAI2FQTEC8rBUcm3DybzVmf8g44t_"></div>

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
                            document.getElementById("pseudo").style.display = "";
                            document.getElementById("pass_confirm").style.display = "";
                            document.getElementById("captcha").style.display = "";
                        } else {
                            document.getElementById("pseudo").style.display = "none";
                            document.getElementById("pass_confirm").style.display = "none";
                            document.getElementById("captcha").style.display = "none";
                        }
                    }
                    switchView(false);
                </script>
            </form>

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