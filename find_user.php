<?php
try {
  // dependecies
  require_once 'Database.php';
  $pdo = Database::getInstance()->getConnection();

  // request
  $userId = intval($_REQUEST['user_id']) ?? 0;

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
  echo json_encode($user);

} catch (Exception $e) {
  echo "Erro: " . $e->getMessage();
}