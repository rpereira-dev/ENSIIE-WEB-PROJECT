<?php

require('../vendor/autoload.php');

use Model\ULC\Discord\API;

$client = API::client();
var_dump($client->guild->getGuild(['guild.id' => API::guildID()]));
var_dump($client->channel->createMessage(['channel.id' => 440662985997025280, 'content' => 'Coucou <@159065769584492544>, ça roule']));
