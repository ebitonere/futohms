<?php
require __DIR__ . '/vendor/autoload.php';

use React\EventLoop\Loop;
use React\Http\Message\Response;
use React\Stream\ThroughStream;



$http = new React\Http\HttpServer(function (Psr\Http\Message\ServerRequestInterface $request) {
    $stream = new ThroughStream();

   $client = new React\Http\Browser();
    $url='http://192.168.1.152/events';
    

    $client->requestStreaming('GET', $url)->then(function (Psr\Http\Message\ResponseInterface $response) {
    $body = $response->getBody();
    assert($body instanceof Psr\Http\Message\StreamInterface);
    assert($body instanceof React\Stream\ReadableStreamInterface);

    $body->on('data', function ($chunk) {
        $stream= $chunk;
    });

    $body->on('error', function (Exception $e) {
        echo 'Error: ' . $e->getMessage() . PHP_EOL;
    });

    $body->on('close', function () {
        echo '[DONE]' . PHP_EOL;
    });




}, function (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;


});

    return new React\Http\Message\Response(
        React\Http\Message\Response::STATUS_OK,
        array(
            'Content-Type' => 'event/stream'
        ),
        $stream
    ); 


});



$socket = new React\Socket\SocketServer('127.0.0.1:3000');
$http->listen($socket);