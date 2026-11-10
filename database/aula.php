
<?php
function getAulasDisponiveis($db) {
    $sql = '
        SELECT
            Aula.id,
            Aula.data,
            Aula.horaInicio,
            Aula.horaFim,
            Aula.nivel,
            Aula.vagas,
            Modalidade.nome AS modalidade,
            Sala.nome AS sala,
            Utilizador.nome AS treinador,

            (
                SELECT COUNT(*)
                FROM Inscricao
                WHERE Inscricao.idAula = Aula.id
                  AND Inscricao.estado = \'ATIVA\'
            ) AS totalInscritos

        FROM Aula
        JOIN Modalidade
            ON Aula.idModalidade = Modalidade.id
        JOIN Sala
            ON Aula.idSala = Sala.id
        JOIN Treinador
            ON Aula.idTreinador = Treinador.idUtilizador
        JOIN Utilizador
            ON Treinador.idUtilizador = Utilizador.id

        WHERE Aula.data >= ?

        ORDER BY Aula.data ASC, Aula.horaInicio ASC
    ';

    $stmt = $db->prepare($sql);
    $stmt->execute(array(date('Y-m-d')));

    return $stmt->fetchAll();
}
