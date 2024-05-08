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
}