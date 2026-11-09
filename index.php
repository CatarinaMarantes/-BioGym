<?php
require_once __DIR__ . '/utils/session.php';
require_once __DIR__ . '/database/connection.php';
require_once __DIR__ . '/templates/common.php';

$db = getDatabaseConnection();
$stmt = $db->prepare('
    SELECT Aula.data, Aula.horaInicio, Aula.horaFim, Aula.nivel,
           Modalidade.nome AS modalidade,
           Utilizador.nome AS treinador,
           Sala.nome AS sala
    FROM Aula
    JOIN Modalidade ON Aula.idModalidade = Modalidade.id
    JOIN Utilizador ON Aula.idTreinador = Utilizador.id
    JOIN Sala ON Aula.idSala = Sala.id
    WHERE Aula.data >= ?
    ORDER BY Aula.data, Aula.horaInicio
');
$stmt->execute(array(date('Y-m-d')));
$aulas = $stmt->fetchAll();

$niveis = array('INICIANTE' => 'Iniciante', 'INTERMEDIO' => 'Intermédio', 'AVANCADO' => 'Avançado');

drawHeader('Início');
?>
<h1>Bem-vindo ao BioGym</h1>
<h2>Próximas aulas</h2>
<?php if (empty($aulas)) { ?>
    <p>Não há aulas agendadas.</p>
<?php } else { ?>
    <ul class="lista-aulas">
        <?php foreach ($aulas as $aula) { ?>
            <li>
                <strong><?= htmlspecialchars($aula['modalidade']) ?></strong>
                (<?= htmlspecialchars($niveis[$aula['nivel']]) ?>)<br>
                <?= date('d/m/Y', strtotime($aula['data'])) ?>,
                <?= htmlspecialchars($aula['horaInicio']) ?>–<?= htmlspecialchars($aula['horaFim']) ?> ·
                <?= htmlspecialchars($aula['sala']) ?> ·
                com <?= htmlspecialchars($aula['treinador']) ?>
            </li>
        <?php } ?>
    </ul>
<?php } ?>
<?php drawFooter(); ?>