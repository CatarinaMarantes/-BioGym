<?php
require_once __DIR__ . '/../utils/session.php';
require_once __DIR__ . '/../database/connection.php';
require_once __DIR__ . '/../database/utilizador.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirecionar('/login.php');
verificarCsrf();

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$db = getDatabaseConnection();
$utilizador = getUtilizadorPorEmail($db, $email);

// A mesma mensagem nos dois casos, para não revelar que emails existem
if (!$utilizador || !password_verify($password, $utilizador['passwordHash'])) {
    adicionarMensagem('erro', 'Email ou palavra-passe incorretos.');
    redirecionar('/login.php');
}

session_regenerate_id(true);
$_SESSION['id']     = $utilizador['id'];
$_SESSION['nome']   = $utilizador['nome'];
$_SESSION['papeis'] = getPapeis($db, $utilizador['id']);

adicionarMensagem('sucesso', 'Bem-vindo, ' . $utilizador['nome'] . '!');
redirecionar('/index.php');
