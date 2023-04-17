<?php
const ROOT = __DIR__ . "/../../";
require ROOT."vendor/autoload.php";
spl_autoload_register(function ($classname) {
    require $filename = ROOT . "app/" . str_replace("\\", "/", $classname) . ".php";
});
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use utils\FormSubmissionServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new FormSubmissionServer()
        )
    ),
    8080
);

print ("Server works!\n");
$server->run();