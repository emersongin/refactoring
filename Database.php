<?php 

// singleton
class Database {
  private static ?Database $instance = null;
  private PDO $pdo;

  private function __construct() {
    try {
      $host = 'localhost';
      $port = '5432';
      $dbname = 'login_db';
      $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
      $dbUser = 'postgres';
      $dbPassword = 'postgres2025';
    
      $this->pdo = new PDO($dsn, $dbUser, $dbPassword);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Erro de conexão: " . $e->getMessage());
    }
  }

  public static function getInstance(): Database {
    if (self::$instance === null) {
      self::$instance = new Database();
    }
    return self::$instance;
  }

  public function getConnection(): PDO {
    return $this->pdo;
  }
}
