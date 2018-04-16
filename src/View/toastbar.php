<?php

namespace View\Toastbar;

function afficher() {
?>
        <!-- la barre des messages d'informations en bas du site (toast) -->
        <script type="text/javascript">
            var toasts = {};
            var nextToastTime = 0;

            function toast(message, level) {
                if (toasts[message]) {
                    return ;
                }
                toasts[message] = true;
                setTimeout(function() {
                    var bar = document.getElementById("toastbar");
                    bar.innerHTML = message;
                    bar.classList.add("show");

                    var color = (level == 0) ? "error" : (level == 1) ? "warning" : "fine";
                    bar.classList.add(color);

                    setTimeout(function() {
                                bar.classList.remove("show");
                                bar.classList.remove(color);
                                nextToastTime -= 2000;
                                toasts[message] = null;
                                }, 2000);
                }, nextToastTime);
                nextToastTime += 2000;
            }
        </script>
        <div id="toastbar">Bienvenue :)</div> 
<?php
}

?>