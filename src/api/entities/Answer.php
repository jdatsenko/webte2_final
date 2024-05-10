
<?php

class Answer 
{
  private $conn;
  public function __construct($conn, $auth)
  {
    $this->conn = $conn;
  }

  public function addAnswerToQuestion($questionId, $data) {
    $isRight = $data["isRight"] == true ? 1 : 0;
    $answer = $data["answer"];
    $query = "INSERT INTO Answer (question_id, isRight, answer) VALUES ($questionId, $isRight, '$answer')";
    $this->conn->query($query);
  }

}
