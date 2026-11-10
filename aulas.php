<?php
require_once __DIR__ . '/utils/session.php';
require_once __DIR__ . '/database/connection.php';
require_once __DIR__ . '/database/aula.php';
require_once __DIR__ . '/templates/common.php';

$db = getDatabaseConnection();
$aulas = getAulasDisponiveis($db);

$niveis = array(
    'INICIANTE' => 'Iniciante',
    'INTERMEDIO' => 'Intermédio',
    'AVANCADO' => 'Avançado'
);

drawHeader('Aulas');
?>

<section class="cabecalho-aulas">
    <div>
        <span class="subtitulo">BIOGYM · ATIVIDADES</span>
        <h1>Explora as nossas aulas</h1>
        <p>Encontra a atividade ideal para ti.</p>
    </div>
</section>

<?php if (empty($aulas)) { ?>

    <p>Não existem aulas agendadas.</p>

<?php } else { ?>

    <div class="grelha-aulas">

        <?php foreach ($aulas as $aula) {
            $vagasDisponiveis = max(
                0,
                $aula['vagas'] - $aula['totalInscritos']
            );
        ?>

            
    <article class="cartao-aula">

        <div class="topo-cartao">
            <h2>
                <?= htmlspecialchars($aula['modalidade']) ?>
            </h2>

            <span class="etiqueta-nivel">
                <?= htmlspecialchars($niveis[$aula['nivel']]) ?>
            </span>
        </div>

        <div class="detalhes-aula">

            <p>
                <strong>Data</strong>
                <span>
                    <?= date('d/m/Y', strtotime($aula['data'])) ?>
                </span>
            </p>

            <p>
                <strong>Horário</strong>
                <span>
                    <?= htmlspecialchars($aula['horaInicio']) ?>
                    –
                    <?= htmlspecialchars($aula['horaFim']) ?>
                </span>
            </p>

            <p>
                <strong>Treinador</strong>
                <span>
                    <?= htmlspecialchars($aula['treinador']) ?>
                </span>
            </p>

            <p>
                <strong>Sala</strong>
                <span>
                    <?= htmlspecialchars($aula['sala']) ?>
                </span>
            </p>

        </div>

        <div class="rodape-cartao">
            <?php if ($vagasDisponiveis > 0) { ?>
                <span class="vagas-disponiveis">
                    <?= $vagasDisponiveis ?> vagas disponíveis
                </span>
            <?php } else { ?>
                <span class="sem-vagas">Aula lotada</span>
            <?php } ?>
        </div>

    </article>

        <?php } ?>

    </div>

<?php } ?>

<?php drawFooter(); ?>
