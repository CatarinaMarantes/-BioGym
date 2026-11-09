<?php
function getUtilizadorPorEmail($db, $email) {
    $stmt = $db->prepare('SELECT * FROM Utilizador WHERE email = ?');
    $stmt->execute(array($email));
    return $stmt->fetch();
}

function emailExiste($db, $email) {
    return getUtilizadorPorEmail($db, $email) !== false;
}

// Devolve os papéis do utilizador, por exemplo array('MEMBRO', 'TREINADOR')
function getPapeis($db, $idUtilizador) {
    $papeis = array();
    $tabelas = array('Membro' => 'MEMBRO', 'Treinador' => 'TREINADOR', 'Administrador' => 'ADMIN');
    foreach ($tabelas as $tabela => $papel) {
        $stmt = $db->prepare("SELECT 1 FROM $tabela WHERE idUtilizador = ?");
        $stmt->execute(array($idUtilizador));
        if ($stmt->fetch()) $papeis[] = $papel;
    }
    return $papeis;
}

// Cria o utilizador e o respetivo membro numa só transação
function criarMembro($db, $nome, $email, $telemovel, $password, $dataNascimento) {
    $db->beginTransaction();
    try {
        $stmt = $db->prepare('INSERT INTO Utilizador (nome, email, telemovel, passwordHash, dataRegisto) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute(array($nome, $email, $telemovel, password_hash($password, PASSWORD_DEFAULT), date('Y-m-d')));
        $id = $db->lastInsertId();

        $stmt = $db->prepare('INSERT INTO Membro (idUtilizador, dataNascimento) VALUES (?, ?)');
        $stmt->execute(array($id, $dataNascimento));

        $db->commit();
        return $id;
    } catch (PDOException $e) {
        $db->rollBack();
        throw $e;
    }
}
