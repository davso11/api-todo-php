<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT, POST');
header('Access-Control-Allow-Headers: *');

require_once '../../config/Database.php';
require_once '../../models/TodoModel.php';
require_once '../../models/UserModel.php';

$database = new Database();
$dbConnection = $database->connect();

// Instantiate models object
$todo = new Todo($dbConnection);
$user = new User($dbConnection);

// check for userId param in the req body
$reqBody = json_decode(file_get_contents('php://input'));

if (
  !isset($reqBody->userId) ||
  !isset($reqBody->todo) ||
  !isset($reqBody->todoId)
) {
  http_response_code(400);
  echo json_encode([
    'message' => 'Missing paramaters in the req body',
    'userId' => $reqBody->userId,
    'todo' => $reqBody->todo,
    'todoId' => $reqBody->todoId
  ]);
  die();
}

// check if user exist
$isUser = $user->findById($reqBody->userId);
$userNum = $isUser->rowCount();

if ($userNum === 0) {
  http_response_code(401);
  echo json_encode([
    'message' => 'No User Found',
    'userId' => $reqBody->userId
  ]);
  die();
}

// fetch todos
$result = $todo->update($reqBody->todo, $reqBody->todoId);

if (!$result) {
  http_response_code(424);
  echo json_encode([
    'message' => 'Cannot Update Todo',
    'todoId' => $reqBody->todoId
  ]);
} else {
  http_response_code(201);
  echo json_encode(['message' => 'Post Not Updated']);
}
