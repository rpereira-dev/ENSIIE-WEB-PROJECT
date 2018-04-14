<?php

namespace Model;

/**
 *  Représente l'API de Riot.
 *  Cet objet facilite les transactions avec les serveurs de Riot.
 */
class RiotAPI {
    
    /** la clef d'API */
    private $api_key;
    
    /**
     * @param string $api_key : une clef d'api valide
     */
    public function __construct($api_key) {
        $this->api_key = $api_key;
    }

    /**
     *	Effectue une requete aux serveurs de Riot
     *
     *	@param service : le service (e.g: /lol/summoner/v3/summoners/by-name/lousticos)
     *	@param arguments : les argugments requit par le service (voir la doc Riot correspond au service)
     *	@param isPost : false <=> GET , true <=> POST
     */
    public function request($service, $arguments, $isPost) {    
    	$ch = curl_init();
    	$url = "https://euw1.api.riotgames.com" . $service . "?" . $this->api_key . "&" . $arguments;
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	echo($url);
    	if ($isPost) {
    		curl_setopt($ch, CURLOPT_POST, 1);
    	}
    	$result = curl_exec($ch);
    	if (curl_errno($ch)) {
    		echo 'Error:' . curl_error($ch);
    	}
    	curl_close ($ch);
    	return ($result);
    }
    
    /*
    private function createProvider() {
    	return (riotRequest("/lol/tournament/v3/providers",
    				"url=localhost:8080/beta&region=EUW",
    				true
    			)
    		);
    }
    */
}

$riot = new RiotAPI("RGAPI-c8a9ce32-aa90-4d6d-b06a-ff99d937dd98");
echo ("<!DOCTYPE html>");
echo ("<html>\n");
echo ('<head><meta http-equiv="content-type" content="text/html; charset=UTF-8"/></head>');
echo ($riot->request("/lol/summoner/v3/summoners/by-name/Lamoukk", "", false));
echo ("<br></br>");
echo ("</html>");

?>
