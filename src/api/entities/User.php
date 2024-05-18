<?php

class User
{
  private $conn;
  private $auth;
  public function __construct($conn, $auth)
  {
    $this->conn = $conn;
    $this->auth = $auth;
  }

  public function getUserInfo()
  {
    if (!$this->auth->isLoggedIn()) {
      die(json_encode(['success' => false, 'message' => 'You are not logged in']));
    }
    $data = ['username' => $this->auth->getUsername(), "email" => $this->auth->getEmail(), "isAdmin" => $this->auth->hasRole(\Delight\Auth\Role::ADMIN)];
    return json_encode(['success' => true, 'data' => $data]);
  }

  public function getAllUsers()
  {
    if (!$this->auth->isLoggedIn()) {
      die(json_encode(['success' => false, 'message' => 'You are not logged in']));
    }
    if (!$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
      die(json_encode(['success' => false, 'message' => 'You are not an admin']));
    }
    $query = "SELECT id, email, username, roles_mask, registered, last_login FROM users";
    $result = mysqli_query($this->conn, $query);
    if ($result === false) {
      die(json_encode(['success' => false, 'message' => 'Error fetching users']));
    }
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $users[] = $row;
    }
    return json_encode(["success" => true, "data" => $users]);
  }

  public function registerUser($data)
  {
    try {
      $userId = $this->auth->register($data["email"], $data["password"], $data["username"]);
      echo json_encode(["success" => true, "userId" => $userId, "message" => "User registered"]);
    } catch (\Delight\Auth\InvalidEmailException $e) {
      die(json_encode(["success" => false, "message" => "Invalid email address"]));
    } catch (\Delight\Auth\InvalidPasswordException $e) {
      die(json_encode(["success" => false, "message" => "Invalid password"]));
    } catch (\Delight\Auth\UserAlreadyExistsException $e) {
      die(json_encode(["success" => false, "message" => "User already exists"]));
    } catch (\Delight\Auth\TooManyRequestsException $e) {
      die(json_encode(["success" => false, "message" => "Too many requests"]));
    }
  }

  public function getUserById($id)
  {
    $query = "SELECT * FROM User WHERE id = $id";
    $result = mysqli_query($this->conn, $query);
    $user = mysqli_fetch_assoc($result);
    return json_encode($user);
  }

  public function loginUser($data)
  {
    $email = $data["email"] ?? null;
    $password = $data["password"] ?? null;

    if ($email === null || $password === null) {
      return json_encode(["error" => "Email and password are required"]);
    }

    try {
      $this->auth->login($email, $password, 60 * 60 * 24);
      echo json_encode(["success" => true, "message" => "Logged in"]);
    } catch (\Delight\Auth\InvalidEmailException $e) {
      die(json_encode(['success' => false, 'message' => 'Wrong email address']));
    } catch (\Delight\Auth\InvalidPasswordException $e) {
      die(json_encode(['success' => false, 'message' => 'Wrong password']));
    } catch (\Delight\Auth\EmailNotVerifiedException $e) {
      die(json_encode(['success' => false, 'message' => 'Email not verified']));
    } catch (\Delight\Auth\TooManyRequestsException $e) {
      die(json_encode(['success' => false, 'message' => 'Too many requests']));
    }
  }

  public function logoutUser()
  {
    try {
      $this->auth->logOutEverywhere();
      echo json_encode(["success" => true, "message" => "Logged out"]);
    } catch (\Delight\Auth\NotLoggedInException $e) {
      die(json_encode(['success' => false, 'message' => 'Not logged in']));
    }
  }

  public function makeAdminById($data)
  {
    if (!$this->auth->isLoggedIn()) {
      die(json_encode(['success' => false, 'message' => 'You are not logged in']));
    }
    if (!$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
      die(json_encode(['success' => false, 'message' => 'You are not an admin']));
    }
    $userId = $data["id"] ?? null;
    if ($userId === null) {
      die(json_encode(["success" => false, "message" => "User ID is required"]));
    }
    try {
      $this->auth->admin()->addRoleForUserById($userId, \Delight\Auth\Role::ADMIN);
      echo (json_encode(["success" => true, "message" => "User is now an admin"]));
    } catch (\Delight\Auth\UnknownIdException $e) {
      die('Unknown user ID');
    }
  }

  public function revokeAdminById($data)
  {
    if (!$this->auth->isLoggedIn()) {
      die(json_encode(['success' => false, 'message' => 'You are not logged in']));
    }
    if (!$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
      die(json_encode(['success' => false, 'message' => 'You are not an admin']));
    }
    $userId = $data["id"] ?? null;
    if ($userId === null) {
      die(json_encode(["success" => false, "message" => "User ID is required"]));
    }
    try {
      $this->auth->admin()->removeRoleForUserById($userId, \Delight\Auth\Role::ADMIN);
      echo (json_encode(["success" => true, "message" => "User is now an admin"]));
    } catch (\Delight\Auth\UnknownIdException $e) {
      die('Unknown user ID');
    }
  }

  public function changePassword($oldPassword, $newPassword)
  {
    try {
      if (!$this->auth->isLoggedIn()) {
        throw new \Delight\Auth\NotLoggedInException();
      }

      $this->auth->changePassword($oldPassword, $newPassword);

      return json_encode(["success" => true, "message" => "Password has been changed"]);
    } catch (\Delight\Auth\NotLoggedInException $e) {
      return json_encode(["success" => false, "message" => "Not logged in"]);
    } catch (\Delight\Auth\InvalidPasswordException $e) {
      return json_encode(["success" => false, "message" => "Invalid password(s)"]);
    } catch (\Delight\Auth\TooManyRequestsException $e) {
      return json_encode(["success" => false, "message" => "Too many requests"]);
    }
  }

  public function getUserQuestions()
  {
    if (!$this->auth->isLoggedIn()) {
      die(json_encode(['success' => false, 'message' => 'You are not logged in']));
    }

    if ($this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
      $query = "SELECT Question.*, COUNT(Response.question_id) AS response_count, users.username
          FROM Question 
          LEFT JOIN Response ON Question.id = Response.question_id 
          LEFT JOIN users ON Question.user_id = users.id
          GROUP BY Question.id";
    } else {
      $query = "SELECT Question.*, COUNT(Response.question_id) AS response_count
                FROM Question 
                LEFT JOIN Response ON Question.id = Response.question_id 
                WHERE Question.user_id = " . $this->auth->getUserId() . "
                GROUP BY Question.id";
    }


    $result = mysqli_query($this->conn, $query);
    $questions = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $questions[] = $row;
    }
    return json_encode(["success" => true, "data" => $questions]);
  }

  public function changeUserPassword($data)
  {
    if (!$this->auth->isLoggedIn()) {
      die(json_encode(['success' => false, 'message' => 'You are not logged in']));
    }
    if (!$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
      die(json_encode(['success' => false, 'message' => 'You are not an admin']));
    }
    $id = $data['id'] ?? null;
    $password = $data['newPassword'] ?? null;
    if ($id === null || $password === null) {
      die(json_encode(['success' => false, 'message' => 'ID and password are required']));
    }
    try {
      $this->auth->admin()->changePasswordForUserById($id, $password);
      echo json_encode(['success' => true, 'message' => 'Password changed']);
    } catch (\Delight\Auth\UnknownIdException $e) {
      die(json_encode(['success' => false, 'message' => 'Unknown user ID']));
    } catch (\Delight\Auth\InvalidPasswordException $e) {
      die(json_encode(['success' => false, 'message' => 'Invalid password']));
    }
  }

  public function changeUserUsername($data)
  {
    if (!$this->auth->isLoggedIn()) {
      die(json_encode(['success' => false, 'message' => 'You are not logged in']));
    }
    if (!$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
      die(json_encode(['success' => false, 'message' => 'You are not an admin']));
    }
    $id = $data['id'] ?? null;
    $username = $data['newUsername'] ?? null;
    if ($id === null || $username === null) {
      die(json_encode(['success' => false, 'message' => 'ID and username are required']));
    }
    $query = "UPDATE users SET username = '$username' WHERE id = $id";
    $result = mysqli_query($this->conn, $query);

    if ($result === false) {
      die(json_encode(["success" => false, "message" => "Error updating username"]));
    }
    return json_encode(["success" => true, "message" => "Username updated"]);
  }

  public function deleteUser($data)
  {
    if (!$this->auth->isLoggedIn()) {
      die(json_encode(['success' => false, 'message' => 'You are not logged in']));
    }
    if (!$this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
      die(json_encode(['success' => false, 'message' => 'You are not an admin']));
    }
    $id = $data['id'] ?? null;
    if ($id === null) {
      die(json_encode(['success' => false, 'message' => 'ID is required']));
    }
    try {
      $this->auth->admin()->deleteUserById($id);
      echo json_encode(['success' => true, 'message' => 'User deleted']);
    } catch (\Delight\Auth\UnknownIdException $e) {
      die('Unknown ID');
    }
  }
}
