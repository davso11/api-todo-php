<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: *');

require_once '../../config/Database.php';
require_once '../../models/TodoModel.php';
require_once '../../models/UserModel.php';

$database = new Database();
$dbConnection = $database->connect();

$todo = new Todo($dbConnection);
$user = new User($dbConnection);

$reqBody = json_decode(file_get_contents('php://input'));

if (
  !isset($reqBody->userId) ||
  !isset($reqBody->todo) ||
  !isset($reqBody->todoId)
) {
  $dbConnection = null;
  http_response_code(400);
  echo json_encode([
    'message' => 'Missing paramaters in the request body',
    'userId' => $reqBody->userId,
    'todo' => $reqBody->todo,
    'todoId' => $reqBody->todoId
  ]);
  die();
}

$foundUser = $user->findById($reqBody->userId)->rowCount();

if ($foundUser === 0) {
  $dbConnection = null;
  http_response_code(401);
  echo json_encode([
    'message' => 'No User Found',
    'userId' => $reqBody->userId
  ]);
  die();
}

$result = $todo->update($reqBody->todo, $reqBody->todoId);

if (!$result) {
  $dbConnection = null;
  http_response_code(412);
  echo json_encode([
    'message' => 'Cannot Update Todo',
    'todoId' => $reqBody->todoId
  ]);
  die();
}

$dbConnection = null;
http_response_code(201);
echo json_encode(['message' => 'Todo Updated']);
