<?php

namespace Model;

use RiotAPI\RiotAPI;
use RiotAPI\Definitions\Region;

/**
 *  Représente l'API de Riot.
 *  Cet objet facilite les transactions avec les serveurs de Riot.
 *
 *  exemple d'utilisation:
 *
 * ``` 
 *      require('../vendor/autoload.php'); 
 *
 *      use Model\ULCRiot;
 *
 *      $riot = ULCRiot::riot();
 *
 *      $summoner = $riot->getSummonerByName('Lamoukk');
 *      var_dump($summoner);
 * ``` 
 *
 */
class ULCRiot {

    /** RiotAPI */
    private static $riot = NULL;

    /**
     *  @return l'instance de RiotAPI
     */
    public static function riot() {
        if (ULCRiot::$riot == NULL) {
            ULCRiot::$riot = new RiotAPI([
                    RiotAPI::SET_KEY    => 'RGAPI-35ccff73-c4d6-4161-9a84-8e1ebc314981',
                    RiotAPI::SET_REGION => Region::EUROPE_WEST,
                ]
            );
        }
        return (ULCRiot::$riot);
    }
}


?>
