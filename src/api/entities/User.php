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
    $data = ['username' => $this->auth->getUsername(), "email" => $this->auth->getEmail(), "roles" => $this->auth->getRoles()];
    return json_encode(['success' => true, 'data'=> $data]);
  }

  public function getAllUsers()
  {
    if (!$this->auth->isLoggedIn()) {
      die(json_encode(['success' => false, 'message' => 'You are not logged in']));
    }
    if (!$this->auth->isAdmin()) {
      die(json_encode(['success' => false, 'message' => 'You are not an admin']));
    }
    $query = "SELECT * FROM User";
    $result = mysqli_query($this->conn, $query);
    $users = mysqli_fetch_assoc($result);
    return json_encode($users);
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
    $userId = $data["userId"] ?? null;
    if (empty($userId)) {
      die(json_encode(["success" => false, "error" => "User ID is required"]));
    }
    try {
      if ($this->auth->isLoggedIn() && $this->auth->hasRole(\Delight\Auth\Role::ADMIN)) {
        $this->auth->admin()->addRoleForUserById($userId, \Delight\Auth\Role::ADMIN);
        echo (json_encode(["success" => true, "message" => "User is now an admin"]));
      } else {
        die(json_encode(["success" => false, "error" => "You are not an admin"]));
      }
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

  public function generateVerificationUrl($email)
  {

    $selector = base64_encode(random_bytes(9));
    $token = bin2hex(random_bytes(32));
    $query = "INSERT INTO email_verification (email, selector, token) VALUES (:email, :selector, :token)";
    $stmt = $this->conn->prepare($query);
    $stmt->execute(['email' => $email, 'selector' => $selector, 'token' => $token]);

    $url = 'https://www.example.com/verify_email?selector=' . urlencode($selector) . '&token=' . urlencode($token);

    return $url;
  }

  // TO DO: sending of the verification email 

  //   public function sendVerificationEmail($email, $selector, $token)
  //   {

  //       $url = 'https://www.example.com/verify_email?selector=' . urlencode($selector) . '&token=' . urlencode($token);
  //       $subject = 'Email Verification';
  //       $message = 'Click on the following link to verify your email address: ' . $url;

  //       if (mail($email, $subject, $message)) {
  //           return true;
  //       } else {
  //           return false; 
  //       }
  //   }
}
