<?php

class Answer 
{
  private $conn;
  private $auth;
  public function __construct($conn, $auth)
  {
    $this->conn = $conn;
    $this->auth = $auth;
  }

  public function addAnswerToQuestion($questionId, $data) {
    $isRight = $data["isRight"] == true ? 1 : 0;
    $answer = $data["answer"];
    $query = "INSERT INTO Answer (question_id, isRight, answer) VALUES ($questionId, $isRight, '$answer')";
    $this->conn->query($query);
    return json_encode(["success" => true, "message" => "Answer added successfully"]);
  }
  public function answerQuestion($data) {
    $userId = $this->auth->getUserId();
    $questionId = $data["questionID"];
    $answerId = $data["answerID"];
    $test = $data["test"];
    
    // user not logged in
    if($userId == null){
      $userId = 1;
    }
    //
    foreach ($answerId as $answer) {
      $query = "INSERT INTO Response (question_id, user_id, answer_id, test) VALUES ($questionId, $userId, $answer, '$test')";
      $this->conn->query($query);
    }   
    return json_encode(["success" => true, "message" => "Question answered successfully"]);
  }

}
