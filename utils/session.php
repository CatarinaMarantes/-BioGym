<?php
session_start();

if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

// Termina o pedido se o token CSRF enviado não coincidir com o da sessão
function verificarCsrf() {
    if (!isset($_POST['csrf']) || !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
        http_response_code(403);
        die('Pedido inválido.');
    }
}

// Guarda uma mensagem para mostrar na próxima página ('sucesso' ou 'erro')
function adicionarMensagem($tipo, $texto) {
    $_SESSION['mensagens'][] = array('tipo' => $tipo, 'texto' => $texto);
}

// Redireciona para outra página e termina o script
function redirecionar($url) {
    header('Location: ' . $url);
    exit();
}
