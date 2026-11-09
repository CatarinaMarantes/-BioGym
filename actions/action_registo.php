<?php
require_once __DIR__ . '/../utils/session.php';
require_once __DIR__ . '/../database/connection.php';
require_once __DIR__ . '/../database/utilizador.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirecionar('/registo.php');
verificarCsrf();

$nome           = trim($_POST['nome'] ?? '');
$email          = trim($_POST['email'] ?? '');
$telemovel      = trim($_POST['telemovel'] ?? '');
$dataNascimento = $_POST['dataNascimento'] ?? '';
$password       = $_POST['password'] ?? '';
$confirmacao    = $_POST['confirmacao'] ?? '';

// Validação no servidor: a validação do HTML pode ser contornada
$erros = array();
if ($nome === '') $erros[] = 'O nome é obrigatório.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = 'Email inválido.';
if (!preg_match('/^9[0-9]{8}$/', $telemovel)) $erros[] = 'O telemóvel deve ter 9 dígitos e começar por 9.';
$data = DateTime::createFromFormat('Y-m-d', $dataNascimento);
if (!$data || $data->format('Y-m-d') !== $dataNascimento || $data > new DateTime()) $erros[] = 'Data de nascimento inválida.';
if (strlen($password) < 8) $erros[] = 'A palavra-passe deve ter pelo menos 8 caracteres.';
if ($password !== $confirmacao) $erros[] = 'As palavras-passe não coincidem.';

$db = getDatabaseConnection();
if (empty($erros) && emailExiste($db, $email)) $erros[] = 'Já existe uma conta com esse email.';

if (!empty($erros)) {
    foreach ($erros as $erro) adicionarMensagem('erro', $erro);
    redirecionar('/registo.php');
}

criarMembro($db, $nome, $email, $telemovel, $password, $dataNascimento);
adicionarMensagem('sucesso', 'Conta criada com sucesso. Já pode entrar.');
redirecionar('/login.php');
