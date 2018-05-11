<?php

/**
 *  Pour ouvrir la Gateway, lancer ULCDiscord::discord() à partir de la ligne de commande
 *
 *  exemple d'utilisation:
 *      require('../vendor/autoload.php'); 
 *
 *      use Model\ULCDiscord;
 *
 *      $client = ULCDiscord::client();
 *      var_dump($client->guild->getGuild(['guild.id' => ULCDiscord::guildID()]));
 *      var_dump($client->channel->createMessage(['channel.id' => 440662985997025280, 'content' => '<@172798956823248896> est une tâche']));
 */
namespace Model\ULC;

use Discord\Discord;
use RestCord\DiscordClient;

/**
 * Représente l'API de Discord.
 * Cet objet facilite les transactions avec le serveur discord
 */
class ULCDiscord {
	
	/**
	 * Discord
	 */
	private static $discord = NULL;
	
	/**
	 * DiscordClient
	 */
	private static $client = NULL;
	
	/**
	 *
	 * @return l'instance de discord
	 */
	public static function discord() {
		if (ULCDiscord::$discord == NULL) {
			ULCDiscord::$discord = new Discord ( [ 
					'token' => ULCDiscord::botToken () 
			] );
			ULCDiscord::$discord->on ( 'ready', function ($discord) {
				echo "Bot is ready!", PHP_EOL;
				
				// Listen for messages.
				ULCDiscord::$discord->on ( 'message', function ($message, $discord) {
					echo "{$message->author->username}: {$message->content}", PHP_EOL;
				} );
			} );
			
			ULCDiscord::$discord->run ();
		}
		return (ULCDiscord::$discord);
	}
	
	/**
	 *
	 * @return DiscordClient : l'instance du client discord
	 */
	public static function client() {
		if (ULCDiscord::$client == NULL) {
			ULCDiscord::$client = new DiscordClient ( [ 
					'token' => ULCDiscord::botToken () 
			] );
		}
		return (ULCDiscord::$client);
	}
	
	/**
	 *
	 * @return string : token du bot
	 */
	public static function botToken() {
		return ('NDMyNTM4MjI1MjgyNzc3MTA4.DcnpUg.DY0sPCmhcM9f7yglkny3ZKPzMUA');
	}
	
	/**
	 *
	 * @return int : id de la guilde Discord
	 */
	public static function guildID() {
		return (432533096609480704);
	}
}

