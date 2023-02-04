<?php
class Database
{
  private $host = '127.0.0.1';
  private $name = 'todo_service_data';
  private $username = 'oda-c5';
  private $password = 'Z4]*bKPnaE(]Q-SV';
  private $connection;

  /**
   * Create a database connection and return it.
   */
  public function connect(): PDO
  {
    $this->connection = null;

    try {
      $this->connection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->name, $this->username, $this->password);
      $this->connection->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
      );
    } catch (PDOException $e) {
      die('Database connection error : ' . $e->getMessage() . "\nLine : " . $e->getLine());
    }

    return $this->connection;
  }
}
