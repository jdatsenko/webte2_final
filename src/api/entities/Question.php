<?php
require_once("Answer.php");

class Question 
{
  private $conn;
  private $auth;

  public function __construct($conn, $auth)
  {
    $this->conn = $conn;
    $this->auth = $auth;
  }

  public function getAllQuestions() {
    $query = "SELECT * FROM Question";
    $result = mysqli_query($this->conn, $query);
    $questions = mysqli_fetch_assoc($result);
    return json_encode($questions);
  }

  public function getQuestionByCode($code) {
    $query = "SELECT * FROM Question WHERE code LIKE '$code'";
    $result = mysqli_query($this->conn, $query);
    $question = mysqli_fetch_assoc($result);
    if (!$question) {
      die(json_encode(["status" => "error", "message" => "Question not found"]));
    }

    $answersQuery = "SELECT test FROM Response WHERE question_id = " . $question["id"];
    $answersResult = mysqli_query($this->conn, $answersQuery);
    $answers = [];
    while ($row = mysqli_fetch_assoc($answersResult)) {
      $answers[] = $row;
    }

    return json_encode(["success" => true, "data" => ["question" => $question, "answers" => $answers]]);

  }

  public function generateCode() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    for ($i = 0; $i < 5; $i++) {
      $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
  }

  public function createQuestion($data) {
    if (!$this->auth->isLoggedIn()) {
        die(json_encode(["status" => "error", "message" => "You are not logged in"]));
    }
    $userId = $this->auth->getUserId();
    $type = $data["type"] ?? null;
    if ($type !== "choice" && $type !== "answer") {
        die(json_encode(["status" => "error", "message" => "Invalid question type"]));
    }
    $subject = $data["subject"] ?? null;
    $question = $data["question"] ?? null;
    if (!$subject) {
        die(json_encode(["status" => "error", "message" => "Subject is required"]));
    }
    if (!$question) {
        die(json_encode(["status" => "error", "message" => "Question is required"]));
    }

    // Generate and ensure code uniqueness
    $code = $this->generateCode();
    $queryControl = "SELECT * FROM Question WHERE code LIKE '$code'";
    $queryControlResult = mysqli_query($this->conn, $queryControl);
    if (!$queryControlResult) {
        die(json_encode(["status" => "error", "message" => "Error checking code uniqueness"]));
    }
    while (mysqli_num_rows($queryControlResult) > 0) {
        $code = $this->generateCode();
        $queryControl = "SELECT * FROM Question WHERE code LIKE '$code'";
        $queryControlResult = mysqli_query($this->conn, $queryControl);
    }

    // Insert question data into database
    $query = "INSERT INTO Question (type, subject, question, isActive, user_id, code) VALUES ('$type', '$subject', '$question', true, '$userId', '$code')";
    mysqli_query($this->conn, $query);
    $questionId = $this->conn->insert_id;

    if ($type == 'choice') {
        $answers = $data["answers"] ?? null;
        if (!$answers) {
            die(json_encode(["status" => "error", "message" => "Answers are required for choice questions"]));
        }
        $answerController = new Answer($this->conn, $this->auth);
        foreach ($answers as $answer) {
            $answerController->addAnswerToQuestion($questionId, $answer);
        } 
    }

    // Return question ID and code
    return json_encode(["status"=> "success", "message"=> "Question created successfully", "data"=> ["questionId" => $questionId, "code" => $code]]);
}

}
