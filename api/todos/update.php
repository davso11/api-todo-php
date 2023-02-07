<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once '../../config/Database.php';
require_once '../../models/TodoModel.php';
require_once '../../models/UserModel.php';

$database = new Database();
$dbConnection = $database->connect();

$todoModel = new Todo($dbConnection);
$user = new User($dbConnection);

$reqBody = json_decode(file_get_contents('php://input'));
$userId = $reqBody->userId;
$todoId = $reqBody->todoId;
$todo = $reqBody->todo;

if (!isset($userId)) {
  $dbConnection = null;
  http_response_code(400);
  exit(json_encode([
    'message' => 'Missing paramaters in the req body',
    'userId' => $userId
  ]));
}

// check if user exist
$foundUser = $user->findById($userId)->rowCount();
    
if ($foundUser === 0) {
    $dbConnection = null;
    http_response_code(401);
    echo json_encode([
      'message' => 'No User Found',
      'userId' => $userId
    ]);
} else {
  $result = $todoModel->update($todo, $todoId);
  
  if (!$result) {
    $dbConnection = null;
    http_response_code(424);
    echo json_encode([
      'message' => 'Cannot Update Todo',
      'todoId' => $todoId
    ]);
  } else {
    $dbConnection = null;
    http_response_code(201);
    echo json_encode([
      'ok' => true,
      'message' => 'Todo Updated',
      'todoObj' => [
        'todo' => $todo,
        'todoId' => $todoId,
        'updatedAt' => intval(time())
      ]
    ]);
  }
}

