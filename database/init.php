<?php
if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('Acesso proibido.');
}

$path = __DIR__ . '/biogym.db';
if (file_exists($path)) unlink($path);

$db = new PDO('sqlite:' . $path);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec(file_get_contents(__DIR__ . '/create.sql'));
$db->exec(file_get_contents(__DIR__ . '/populate.sql'));

echo 'Base de dados criada. Utilizadores: ' . $db->query('SELECT COUNT(*) FROM Utilizador')->fetchColumn();