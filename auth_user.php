<?php

try {
  // dependecies
  require_once 'Database.php';
  $pdo = Database::getInstance()->getConnection();

  // request
  $username = $_REQUEST['username'] ?? '';
  $userPassword = $_REQUEST['password'] ?? '';

  if (empty($username) || empty($userPassword)) {
    throw new Exception("Usuário ou senha não informados");
  }

  $passwordHash = sha1($userPassword);

  // application
  $query = "SELECT
      u.id IS NOT NULL AS exists
    FROM
      users u
    WHERE
      u.username = :username
      AND u.password = :password_hash";
  $stmt = $pdo->prepare($query);

  // para evitar SQL Injection
  $stmt->bindParam(':username', $username, PDO::PARAM_STR);
  $stmt->bindParam(':password_hash', $passwordHash, PDO::PARAM_STR);

  // executa a query
  $stmt->execute();

  // executa a query
  $userData = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!($userData['exists'] ?? false)) {
    throw new Exception("Usuário ou senha inválidos");
  }

  $token = sha1(uniqid($username, true));
  $response = [ 'token' => $token ];
  echo json_encode($response);
} catch (Exception $e) {
  echo "Erro: " . $e->getMessage();
}