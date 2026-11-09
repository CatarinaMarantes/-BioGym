<?php
require_once __DIR__ . '/utils/session.php';
require_once __DIR__ . '/templates/common.php';

if (isset($_SESSION['id'])) redirecionar('/index.php');

drawHeader('Registar');
?>
<section class="formulario">
    <h1>Criar conta</h1>
    <form action="/actions/action_registo.php" method="post">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">

        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="telemovel">Telemóvel</label>
        <input type="tel" id="telemovel" name="telemovel" pattern="9[0-9]{8}" placeholder="912345678" required>

        <label for="dataNascimento">Data de nascimento</label>
        <input type="date" id="dataNascimento" name="dataNascimento" required>

        <label for="password">Palavra-passe (mínimo 8 caracteres)</label>
        <input type="password" id="password" name="password" minlength="8" required>

        <label for="confirmacao">Confirmar palavra-passe</label>
        <input type="password" id="confirmacao" name="confirmacao" minlength="8" required>

        <button type="submit">Registar</button>
    </form>
    <p>Já tem conta? <a href="/login.php">Entrar</a></p>
</section>
<?php drawFooter(); ?>
