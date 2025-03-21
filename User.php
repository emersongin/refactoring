<?php

class User {
  private null | int $id;
  private string $username;
  private string $password;

  public function __construct(string $username, string $password, int $id = null) {
    $this->id = $id;
    if (strlen($username) < 6) {
      throw new Exception("Usuário deve ter no mínimo 6 caracteres");
    }
    $this->username = $username;
    if (strlen($password) < 6) {
      throw new Exception("Senha deve ter no mínimo 6 caracteres");
    }
    $this->password = $password;
  }

  public function getId() {
    return $this->id;
  }

  public function getUsername() {
    return $this->username;
  }

  public function getPassword() {
    return $this->password;
  }
}