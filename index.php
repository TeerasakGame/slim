<?php

require 'vendor/autoload.php';

$app = new \Slim\App();

$app->get('/', function ($request, $response, $args) {
    echo "Welcome to Slim!";
});
//get all
$app->get('/user', function ($request,  $response, $args) {
    include 'database.php';
    $sql = "SELECT id, name FROM user  order by id";
    $result = $conn->query($sql);
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($data,$row);
        }
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withStatus(200);
    } else {
        return $response->withStatus(204);
    }
});
// get by id
$app->get('/user/{id}', function ($request,  $response, $args) {
    include 'database.php';
    $sql = "SELECT id, name FROM user WHERE id = ".$args['id'];
    $result = $conn->query($sql);
    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
        $payload = json_encode($data);
        $response->getBody()->write($payload);
        return $response->withStatus(200);
    } else {
        return $response->withStatus(204);
    }
});
//add user
$app->post('/user', function ($request,  $response, $args) {
    include 'database.php';
    $name = $request->getparam('name');
    if($name){
        $sql = "INSERT INTO user (name) VALUES ('$name');";
        if ($conn->query($sql) === TRUE) {
            $payload = json_encode(true);
            $response->getBody()->write($payload);
            return $response->withStatus(201);
        } else {
            $payload = json_encode(false);
            $response->getBody()->write($payload);
            return $response->withStatus(200);
        }
    }else{
        $payload = json_encode(false);
        $response->getBody()->write($payload);
        return $response->withStatus(200);
    }
    
});
//update
$app->put('/user/{id}', function ($request,  $response, $args) {
    include 'database.php';
    $name = $request->getparam('name');
    $id = $args['id'];
    $sql = "UPDATE user SET name='$name' WHERE id= $id";
    if ($conn->query($sql) === TRUE) {
        // echo json_encode(true);
        $payload = json_encode(true);
        $response->getBody()->write($payload);
        return $response->withStatus(200);
    } else {
        // echo json_encode(false);
        $payload = json_encode(false);
        $response->getBody()->write($payload);
        return $response->withStatus(200);
    }
});
//delete
$app->delete('/user/{id}', function ($request,  $response, $args) {
    include 'database.php';
    $id = $args['id'];
    $sql = "DELETE FROM user WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $payload = json_encode(true);
        $response->getBody()->write($payload);
        return $response->withStatus(200);
    } else {
        $payload = json_encode(false);
        $response->getBody()->write($payload);
        return $response->withStatus(200);
    }
});

$app->run();

?>