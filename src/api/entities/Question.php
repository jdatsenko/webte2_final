<?php

class Question 
{
  private $conn;
  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function getallQuestions() {
    $query = "SELECT * FROM Question";
    $result = mysqli_query($this->conn, $query);
    $questions = mysqli_fetch_assoc($result);
    return $questions;
  }

  public function getQuestionByCode($code) {
    $query = "SELECT * FROM Question WHERE code LIKE '$code'";
    $result = mysqli_query($this->conn, $query);
    $question = mysqli_fetch_assoc($result);
    return $question;
  }
}