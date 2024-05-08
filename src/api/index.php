<?php
require_once("config.php");
require_once("./entities/User.php");

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = explode('/', $_SERVER['REQUEST_URI'])[2] ?? null;
$action = explode('/', $_SERVER['REQUEST_URI'])[3] ?? null;
$id = explode('/', $_SERVER['REQUEST_URI'])[4] ?? null;

header('Content-Type: application/json');

$userController = new User($connection);

if ($method == 'GET') {
  if ($endpoint == 'users') {
    if ($action == 'all') {
      $users = $userController->getAllUsers();
      echo json_encode($users);
    } else if ($action == 'get') {
      $user = $userController->getUserById($id);
      echo json_encode($user);
    }
  }
} else if ($method == 'POST') {
  if ($endpoint == 'users') {
    if ($action == 'create') {
      $data = json_decode(file_get_contents('php://input'), true);
      $user = $userController->createUser($data);
      echo json_encode($user);
    }
  }
}