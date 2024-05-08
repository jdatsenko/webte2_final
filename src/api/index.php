<?php
require_once("config.php");
require_once("./entities/User.php");

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = explode('/', $_SERVER['REQUEST_URI'])[2] ?? null;
$action = explode('/', $_SERVER['REQUEST_URI'])[3] ?? null;
$id = explode('/', $_SERVER['REQUEST_URI'])[4] ?? null;

// echo 'Method: ' . $method . '<br>';
// echo 'Endpoint: ' . $endpoint . '<br>';
// echo 'Action: ' . $action . '<br>';
// echo 'ID: ' . $id . '<br>';

header('Content-Type: application/json');

$userController = new User($connection);

if ($method == 'GET') {
  if ($endpoint == 'users') {
    if ($action == 'all') {
      $users = $userController->getAllUsers();
      echo json_encode($users);
    }
    // } else if ($action == 'get') {
    //   $user = $userController->getUser($id);
    //   echo json_encode($user);
    // }
  }
}