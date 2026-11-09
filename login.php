<?php
require_once __DIR__ . '/utils/session.php';
require_once __DIR__ . '/templates/common.php';

if (isset($_SESSION['id'])) redirecionar('/index.php');

drawHeader('Entrar');
?>
<section class="formulario">
    <h1>Entrar</h1>
    <form action="/actions/action_login.php" method="post">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Palavra-passe</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Entrar</button>
    </form>
    <p>Ainda não tem conta? <a href="/registo.php">Registar</a></p>
</section>
<?php drawFooter(); ?>
