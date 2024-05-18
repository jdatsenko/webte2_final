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

  public function addAnswerToQuestion($questionId, $data)
  {
    $isRight = $data["isRight"] == true ? 1 : 0;
    $answer = $data["answer"];
    $query = "INSERT INTO Answer (question_id, isRight, answer) VALUES ($questionId, $isRight, '$answer')";
    $this->conn->query($query);
    return json_encode(["success" => true, "message" => "Answer added successfully"]);
  }

  public function deleteAnswer($data)
  {
    $answerId = $data["answerID"];
    $query = "DELETE FROM Answer WHERE id = $answerId";
    $this->conn->query($query);
    return json_encode(["success" => true, "message" => "Answer deleted successfully"]);
  }
  public function answerQuestion($data)
  {
    $userId = $this->auth->getUserId();
    $questionId = $data["questionID"];
    $answerId = $data["answerID"] ?? null;
    $text = $data["text"] ?? null;
    if (!$questionId) {
      die(json_encode(["success" => false, "message" => "Question not found"]));
    }
    if ($answerId == null) {
      $query = "INSERT INTO Response (question_id, text) VALUES ($questionId, '$text')";
      $this->conn->query($query);
    } else {
      foreach ($answerId as $answer) {
        $query = "INSERT INTO Response (question_id, user_id, answer_id, text) VALUES ($questionId, $userId, $answer, '$text')";
        $this->conn->query($query);
      }
    }

    return json_encode(["success" => true, "message" => "Question answered successfully"]);
  }

  public function getAnswers($questionId)
  {
    $query = "SELECT id FROM Question WHERE code = ?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $questionId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $questionIdResult); 
    mysqli_stmt_fetch($stmt);
    $id = $questionIdResult;
    mysqli_stmt_close($stmt);

    
    $query = "SELECT type FROM Question WHERE id = $id";
    $result = mysqli_query($this->conn, $query);
    $type = mysqli_fetch_assoc($result);

    if ($type['type'] === "choice") {
      $query = "SELECT R.answer_id, COUNT(R.answer_id) AS count, A.isRight 
                FROM Response R
                LEFT JOIN Answer A ON R.answer_id = A.id
                WHERE R.question_id = ?
                GROUP BY R.answer_id";
      $stmt = mysqli_prepare($this->conn, $query);
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      $response = [];
      while ($row = mysqli_fetch_assoc($result)) {
        $response[] = [
          'answer_id' => $row['answer_id'],
          'count' => $row['count'],
          'isRight' => $row['isRight']
        ];
      }
      mysqli_stmt_close($stmt);
      return json_encode(["success" => true, "responses" => $response]);
    } else if ($type['type'] === "answer") {
      $query = "SELECT text, COUNT(*) AS count
          FROM Response
          WHERE question_id = ?
          GROUP BY text";
      $stmt = mysqli_prepare($this->conn, $query);
      mysqli_stmt_bind_param($stmt, "i", $id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);

      $response = [];
      while ($row = mysqli_fetch_assoc($result)) {
        $response[] = [
          'text' => $row['text'],
          'count' => $row['count']
        ];
      }
      mysqli_stmt_close($stmt);
      return json_encode(["success" => true, "responses" => $response]);
    }
  }
}
