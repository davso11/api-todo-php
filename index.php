<?php
header('Content-Type: application/json');
echo json_encode([
  'message' => 'Hello PHP !',
  'root_dir' => __DIR__
]);
?>
