<?php

namespace View\Sidebar;

function afficher() {
?>
        <!-- barre de navigation à gauche -->
        <section class="sidebar">
            <!-- le logo -->
            <img class="sidebar-logo" src="./images/logo2.png" />

            <!-- la section 'Menu' -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Menu</div>
                <div class="sidebar-section-item"><i class="fa fa-home"></i>Accueil</div>
                <div class="sidebar-section-item"><i class="fa fa-user"></i>Les joueurs</div>
                <div class="sidebar-section-item"><i class="fa fa-users"></i>Les tournois</div>
                <div class="sidebar-section-item"><i class="fa fa-graduation-cap"></i>Les écoles</div>
            </div>

            <!-- la section 'Jeux' -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Jeux</div>
                <div class="sidebar-section-item"><img src="./images/lol.png"/>League of Legends</div>
                <div class="sidebar-section-item"><img src="./images/fortnite.png"/></i>Fortnite</div>
                <div class="sidebar-section-item"><img src="./images/hs.png"/></i>Hearthstone</div>
                <div class="sidebar-section-item"><img src="./images/csgo.png"/></i>Counter Strike: Go</div>
                <div class="sidebar-section-item"><img src="./images/mc.jpg"/></i>Minecraft</div>
            </div>

            <!-- la section 'A propos' -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">A propos de nous</div>
                <div class="sidebar-section-item"><i class="fa fa-users"></i>L'équipe</div>
                <div class="sidebar-section-item"><i class="fa fa-book"></i>Notre politque</div>
                <div class="sidebar-section-item"><i class="fa fa-gavel"></i>Contribuer</div>
                <div class="sidebar-section-item"></div>
            </div>

        </section>
<?php
}
?>