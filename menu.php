<?php
use App\Util\Auth;
?>
<header class="topo">
    <h1>Gerenciador de Tarefas Colaborativo</h1>
    <nav class="menu">
        <a href="./?p=home">Home</a>
        <?php if (Auth::estaLogado()): ?>
            <a href="./?p=tarefas">Tarefas</a>
            <a href="./?p=nova_tarefa">Nova Tarefa</a>
            <a href="./?p=logout">Sair</a>
            <span class="usuario-logado">Olá, <?= htmlspecialchars(Auth::usuarioNome()) ?></span>
        <?php else: ?>
            <a href="./?p=login">Login</a>
            <a href="./?p=cadastro">Cadastro</a>
        <?php endif; ?>
    </nav>
</header>
