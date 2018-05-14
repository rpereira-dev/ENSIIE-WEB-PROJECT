<?php

require('../vendor/autoload.php');

use Model\ULC\Discord\API;

$client = API::client();
$client->channel->createMessage(['channel.id' => 440662985997025280, 'content' => 'Coucou <@382175522832121857>, ça roule']);
