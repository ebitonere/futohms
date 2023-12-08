<?php

  header('Content-Type: text/event-stream');
         header('Cache-Control: no-cache'); 
    require __DIR__ . '/vendor/autoload.php';
   $client = new React\Http\Browser();

   use League\Event\Event;

   function dispatch($data){
     echo $data;
     flush();
   }


    $url='http://192.168.1.182/';

    $client->requestStreaming('GET', $url)->then(function (Psr\Http\Message\ResponseInterface $response) {
    $body = $response->getBody();
    assert($body instanceof Psr\Http\Message\StreamInterface);
    assert($body instanceof React\Stream\ReadableStreamInterface);

    $body->on('data', function ($chunk) {
        echo $chunk;
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


?>