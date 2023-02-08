<?php
class Todo
{
  private $connection;
  private $table = 'todo';

  public function __construct(PDO $dbConnection)
  {
    $this->connection = $dbConnection;
  }

  public function getAll(string $userId)
  {
    // sql query
    $sql = "SELECT todoId, todo, isImportant, updatedAt
        FROM {$this->table} WHERE userId = ? ORDER BY id ASC";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt;
  }

  public function update(string $todoId, string $todo, bool $isImportant)
  {
    if ($isImportant === true) {
      $isImportant = 1;
    } elseif ($isImportant === false){
      $isImportant = 0;
    }

    $sql =
      'UPDATE todo SET todo = ?, updatedAt = CURRENT_TIMESTAMP, isImportant = ? WHERE todoId = ?';
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([$todo, $isImportant, $todoId]);
    return $stmt;
  }
}
