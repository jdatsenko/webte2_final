<?php
require_once("config.php");
require_once("./entities/User.php");
require_once("./entities/Question.php");

$method = $_SERVER['REQUEST_METHOD'];
$endpoint = explode('/', $_SERVER['REQUEST_URI'])[2] ?? null;
$subEndpoint = explode('/', $_SERVER['REQUEST_URI'])[3] ?? null;

header('Content-Type: application/json');

$userController = new User($connection, $auth);
$questionController = new Question($connection, $auth);
$answerController = new Answer($connection, $auth);

$data = json_decode(file_get_contents('php://input'), true);

if ($method == 'GET') {
  if ($endpoint == 'users') {
    if ($subEndpoint == 'all') {
      echo $userController->getAllUsers();
    } else if (is_numeric($subEndpoint)) {
      echo $userController->getUserById($subEndpoint);
    } else if ($subEndpoint == 'getInfo') {
      echo $userController->getUserInfo();
    } else if ($subEndpoint == 'getQuestions') {
      echo $userController->getUserQuestions();
    } else {
      echo json_encode(array('error' => 'Invalid endpoint'));
    }
  } else if ($endpoint == 'questions') {
    if ($subEndpoint == 'all') {
      echo $questionController->getAllQuestions();
    } else if ($subEndpoint) {
      echo $questionController->getQuestionByCode($subEndpoint);
    } else {
      echo json_encode(array('error' => 'Invalid question endpoint'));
    }
  } else if ($endpoint == 'answers') {
    if ($subEndpoint) {
      echo $answerController->getAnswers($subEndpoint);
    }
  }
} else if ($method == 'POST') {
  if ($endpoint == 'users') {
    if ($subEndpoint == 'register') {
      echo $userController->registerUser($data);
    } else if ($subEndpoint == 'login') {
      echo $userController->loginUser($data);
    } else if ($subEndpoint == 'logout') {
      echo $userController->logoutUser();
    } else if ($subEndpoint = "makeAdmin") {
      echo $userController->makeAdminById($data);
    } else if ($subEndpoint == 'makeAdmin') {
      echo $userController->makeAdminById($data);
    } else if ($subEndpoint == 'changePassword') {
      // Call the changePassword method
      echo $userController->changePassword($data['oldPassword'], $data['newPassword']);
    } else {
      echo json_encode(array('error' => 'Invalid endpoint'));
    }
  } else if ($endpoint == 'questions') {
    if ($subEndpoint == 'create') {
      echo $questionController->createQuestion($data);
    } else if ($subEndpoint == "getResponses") {
      echo $questionController->getQuestionResponses($data);
    } else if ($subEndpoint == "delete") {
      echo $questionController->deleteQuestion($data);
    } else if($subEndpoint == "duplicate") {
      echo $questionController->duplicateQuestion($data);
    } else {
      echo json_encode(array('error' => 'Invalid endpoint'));
    }
  } else if ($endpoint == 'answers') {
    if ($subEndpoint == 'create') {
      echo $answerController->answerQuestion($data);
    } else {
      echo json_encode(array('error' => 'Invalid endpoint'));
    }
  } else {
    // Handle unsupported request methods
    echo json_encode(array('error' => 'Unsupported request method'));
  }
}
