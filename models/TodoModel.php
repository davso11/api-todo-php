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
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt;
  }

  public function update(string $todo, string $todoId)
  {
    $sql =
      'UPDATE todo SET todo = ?, updatedAt = CURRENT_TIMESTAMP WHERE todoId = ?';
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([$todo, $todoId]);
    return $stmt;
  }
}
