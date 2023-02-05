<?php
class User
{
  private $connection = null;

  public function __construct(PDO $dbConnection)
  {
    $this->connection = $dbConnection;
  }

  public function findById(string $userId)
  {
    $sql = 'SELECT userId FROM user WHERE userId = ?';
    $stmt = $this->connection->prepare($sql);
    $stmt->execute([$userId]);
    return $stmt;
  }
}
