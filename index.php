<?php

require 'vendor/autoload.php';

$app = new \Slim\App();

$app->get('/', function ($request, $response, $args) {
    echo "Welcome to Slim!";
});

$app->get('/hello/{name}', function ( $request,  $response, $args) {
    $name = $args['name'];
    echo "<pre>";
    print_r($request);
    print_r($response);
    echo "Hello, $name";
});

$app->run();

?>