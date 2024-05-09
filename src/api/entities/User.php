<?php

class User 
{
  private $conn;
  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function getAllUsers() {
    $query = "SELECT * FROM User";
    $result = mysqli_query($this->conn, $query);
    $users = mysqli_fetch_assoc($result);
    return $users;
  }

  public function createUser($data) {
    $email = $data["email"];
    $password = password_hash($data["password"], PASSWORD_DEFAULT);

    $query = "INSERT INTO User (email, password, isAdmin, createdAt) VALUES ('$email', '$password', 0, NOW())";
    $result = mysqli_query($this->conn, $query);
    return $result;
  }

  public function getUserById($id) {
    $query = "SELECT * FROM User WHERE id = $id";
    $result = mysqli_query($this->conn, $query);
    $user = mysqli_fetch_assoc($result);
    return $user;
  }

  public function loginUser($email, $password) {
    $query = "SELECT * FROM User WHERE email = '$email'";
    $result = mysqli_query($this->conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
      return $user;
    } else {
      if (!$user) {
        return "User not found.";
      } else {
          return "Incorrect password.";
      }
    }
  }
}