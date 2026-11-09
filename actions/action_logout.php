<?php
require_once __DIR__ . '/../utils/session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirecionar('/index.php');
verificarCsrf();

session_destroy();
session_start();
adicionarMensagem('sucesso', 'Sessão terminada.');
redirecionar('/index.php');
