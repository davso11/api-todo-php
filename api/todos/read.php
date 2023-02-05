<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');

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
$userId = $reqBody->userId;

if (!isset($userId)) {
  http_response_code(400);
  echo json_encode([
    'message' => 'Missing paramaters in the req body',
    'userId' => $userId
  ]);
  die();
}

// check if user exist
$isUser = $user->findById($userId);
$userNum = $isUser->rowCount();

if ($userNum === 0) {
  http_response_code(401);
  echo json_encode(['message' => 'No User Found', 'userId' => $userId]);
  die();
}

// fetch todos
$result = $todo->getAll($userId);
$num = $result->rowCount();

// check if any todos
if ($num === 0) {
  echo json_encode(['message' => 'No Todo Found']);
  die();
}

// send todos
echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));

$dbConnection = null;
