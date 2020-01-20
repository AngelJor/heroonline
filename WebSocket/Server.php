<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/WebSocket/Chat.php';

$chat = new Chat();
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            $chat
        )
    ),
    8080
);
$server->run();