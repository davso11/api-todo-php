<?php
class Todo
{
  private $connection;
  private $table = 'todo';

  public $todoId;
  public $todo;
  public $createdAt;
  public $updatedAt;

  public function __construct(PDO $dbConnection)
  {
    $this->connection = $dbConnection;
  }

  public function getAll(string $userId)
  {
    // sql query
    $sql = "SELECT todoId, todo, createdAt, updatedAt
        FROM {$this->table} WHERE userId = ? ORDER BY id ASC";

    // prepare statement
    $stmt = $this->connection->prepare($sql);

    // execute
    $stmt->execute([$userId]);

    return $stmt;
  }
}
