<?php

require 'vendor/autoload.php';

$app = new \Slim\App();

$app->get('/', function ($request, $response, $args) {
    echo "Welcome to Slim!";
});
//get all
$app->get('/user', function ($request,  $response, $args) {
    include 'database.php';
    $sql = "SELECT id, name FROM user";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo json_encode($row);
        }
    } else {
        echo json_encode(false);
    }
});
// get by id
$app->get('/user/{id}', function ($request,  $response, $args) {
    include 'database.php';
    $sql = "SELECT id, name FROM user WHERE id = ".$args['id'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo json_encode($row);
        }
    } else {
        echo json_encode(false);
    }
});
//add user
$app->post('/user', function ($request,  $response, $args) {
    include 'database.php';
    $name = $request->getparam('name');
    $sql = "INSERT INTO user (name) VALUES ('$name');";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(true);;
    } else {
        echo json_encode(false);
    }
});
//update
$app->put('/user/{id}', function ($request,  $response, $args) {
    include 'database.php';
    $name = $request->getparam('name');
    $id = $args['id'];
    $sql = "UPDATE user SET name='$name' WHERE id= $id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(true);;
    } else {
        echo json_encode(false);
    }
});
//delete
$app->delete('/user/{id}', function ($request,  $response, $args) {
    include 'database.php';
    $id = $args['id'];
    $sql = "DELETE FROM user WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(true);;
    } else {
        echo json_encode(false);
    }
});

$app->run();

?>