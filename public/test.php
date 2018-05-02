<?php

require('../vendor/autoload.php'); 
use Model\ULCRiot;
$riot = ULCRiot::riot();
try {
	$summoner = $riot->getSummonerByName('PCF toss');
} catch (Exception $e) {
	echo 'nop';
}
var_dump($summoner);
$code = $riot->getThirdPartyCodeBySummonerId($summoner->id);
var_dump($code);
?>