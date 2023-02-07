<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: *');

require_once '../../config/Database.php';
require_once '../../models/TodoModel.php';
require_once '../../models/UserModel.php';

$database = new Database();
$dbConnection = $database->connect();

$todo = new Todo($dbConnection);
$user = new User($dbConnection);

$reqBody = json_decode(file_get_contents('php://input'));
$userId = $reqBody->userId;

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
    'message' => 'No User With That ID Found',
    'userId' => $userId
  ]);
  exit;
}

$result = $todo->getAll($userId);
$todoNum = $result->rowCount();


$dbConnection = null;
echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));
