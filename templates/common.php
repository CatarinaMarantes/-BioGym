<?php
function drawHeader($titulo) { ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($titulo) ?> · BioGym</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <a href="/index.php" class="logo">BioGym</a>
        <nav>
            <a href="/aulas.php">Aulas</a>
            <?php if (isset($_SESSION['id'])) { ?>
                <span>Olá, <?= htmlspecialchars($_SESSION['nome']) ?></span>
                <form action="/actions/action_logout.php" method="post">
                    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
                    <button type="submit">Sair</button>
                </form>
            <?php } else { ?>
                <a href="/login.php">Entrar</a>
                <a href="/registo.php">Registar</a>
            <?php } ?>
        </nav>
    </header>
    <main>
        <?php drawMensagens(); ?>
<?php }

function drawMensagens() {
    if (empty($_SESSION['mensagens'])) return;
    foreach ($_SESSION['mensagens'] as $mensagem) { ?>
        <p class="mensagem <?= $mensagem['tipo'] ?>"><?= htmlspecialchars($mensagem['texto']) ?></p>
    <?php }
    unset($_SESSION['mensagens']);
}

function drawFooter() { ?>
    </main>
    <footer>
        <p>&copy; 2026 BioGym · Projeto ESIN</p>
    </footer>
</body>
</html>
<?php }
