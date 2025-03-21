<?php

try {
  // dependecies
  require_once 'Database.php';
  require_once 'User.php';
  $pdo = Database::getInstance()->getConnection();

  // request
  $username = $_REQUEST['username'] ?? '';
  $userPassword = $_REQUEST['password'] ?? '';

  if (empty($username) || empty($userPassword)) {
    throw new Exception("Usuário ou senha não informados");
  }

  $user = new User($username, $userPassword);
  $passwordHash = sha1($userPassword);
  
  // application
  $query = "INSERT INTO users (username, password) VALUES (:username, :password_hash)";
  $stmt = $pdo->prepare($query);

  // para evitar SQL Injection
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':password_hash', $passwordHash);

  // executa a query
  $stmt->execute();

  // response
  $userId = $pdo->lastInsertId();
  // echo "Usuário inserido com sucesso. ID: $userId";

  echo find_user($userId);

} catch (Exception $e) {
  echo "Erro na conexão com o PostgreSQL: " . $e->getMessage();
}

function find_user($userId) {
  $pdo = Database::getInstance()->getConnection();

  if ($userId == 0) {
    throw new Exception("ID do usuário não informado");
  }
  
  // application
  $query = "SELECT
        u.id,
        u.username
      FROM
        users u
      WHERE
        u.id = :user_id";
  $stmt = $pdo->prepare($query);

  // para evitar SQL Injection
  $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

  // executa a query
  $stmt->execute();

  // executa a query
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if (empty($user)) {
    throw new Exception("Usuário não encontrado");
  }

  // response
  return json_encode($user);
}