<?php

$rota = $_REQUEST['rota'];

if ($rota == 'create_user') {
  require_once 'create_user.php';
} else if ($rota == 'find_user') {
  require_once 'find_user.php';
} else if ($rota == 'auth_user') {
  require_once 'auth_user.php';
} else {
  echo "Rota não encontrada";
}