<?php
header('Content-Type: application/json');
// echo json_encode([
//   'message' => 'Hello PHP !',
//   'root_dir' => __DIR__
// ]);

function getPost()
{
  if (!empty($_POST)) {
    // when using application/x-www-form-urlencoded or multipart/form-data as the HTTP Content-Type in the request
    // NOTE: if this is the case and $_POST is empty, check the variables_order in php.ini! - it must contain the letter P
    return json_encode([
      'message' => $_POST['message']
    ]);
  }

  // when using application/json as the HTTP Content-Type in the request
  $post = file_get_contents('php://input');
  if (json_last_error() == JSON_ERROR_NONE) {
    return $post;
  }
}

echo getPost();
?>
