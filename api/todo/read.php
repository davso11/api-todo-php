<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/TodoModel.php';

$database = new Database();
$dbConnection = $database->connect();

// Instantiate todo object
$todo = new Todo($dbConnection);

// fetch todos
$result = $todo->getAll("6dd81adb-e0e8-4115-a014-0c7760a362bc");
$num = $result->rowCount();

// check if any todos
if ($num > 0) {
  $todosArr = [];

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $todosArr = [
      'todoId' => $todoId,
      'todo' => $todo,
      'createdAt' => $createdAt,
      'updatedAt' => $updatedAt
    ];

    // Push to "data"
    array_push($todosArr, $todosArr);

    // Turn to JSON & output
    echo json_encode($todosArr);
  }
} else {
  // No Posts
  echo json_encode(['message' => 'No Posts Found']);
}

$dbConnection = null;