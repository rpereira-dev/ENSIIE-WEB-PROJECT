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
                <div onclick="redirectToPage('accueil');" class="sidebar-section-item"><i class="fa fa-home"></i>Accueil</div>
                <div onclick="redirectToPage('ecoles');" class="sidebar-section-item"><i class="fa fa-graduation-cap"></i>Les écoles</div>
                <div onclick="redirectToPage('joueurs');" class="sidebar-section-item"><i class="fa fa-user"></i>Les joueurs</div>
                <div onclick="redirectToPage('tournois');" class="sidebar-section-item"><i class="fa fa-users"></i>Les tournois</div>
                <div onclick="redirectToPage('live');" class="sidebar-section-item"><i class="fa fa-twitch"></i>Live Twitch</div>
            </div>

            <!-- la section 'Jeux' -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">Jeux</div>
                <div onclick="redirectToPage('lol');" class="sidebar-section-item"><img src="./images/lol.png"/>League of Legends</div>
                <div onclick="redirectToPage('fortnite');" class="sidebar-section-item"><img src="./images/fortnite.png"/></i>Fortnite</div>
                <div onclick="redirectToPage('hs');" class="sidebar-section-item"><img src="./images/hs.png"/></i>Hearthstone</div>
                <div onclick="redirectToPage('csgo');" class="sidebar-section-item"><img src="./images/csgo.png"/></i>Counter Strike: Go</div>
                <div onclick="redirectToPage('mc');" class="sidebar-section-item"><img src="./images/mc.jpg"/></i>Minecraft</div>
            </div>

            <!-- la section 'A propos' -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">A propos de nous</div>
                <div class="sidebar-section-item"><i class="fa fa-users"></i>L'équipe</div>
                <div class="sidebar-section-item"><i class="fa fa-book"></i>Notre politque</div>
                <div class="sidebar-section-item"><i class="fa fa-gavel"></i>Contribuer</div>
            </div>

        </section>
<?php
}
?>