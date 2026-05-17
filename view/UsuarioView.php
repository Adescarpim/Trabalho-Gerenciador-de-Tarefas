<?php
namespace App\View;

class UsuarioView
{
    public static function formularioCadastro(?string $mensagem): void
    {
        ?>
        <section class="card formulario">
            <h2>Cadastro de Usuário</h2>
            <?php if ($mensagem): ?><p class="mensagem"><?= htmlspecialchars($mensagem) ?></p><?php endif; ?>

            <form method="POST" action="./?p=cadastro">
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome" required>

                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" required>

                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>

                <button type="submit">Cadastrar</button>
            </form>
        </section>
        <?php
    }

    public static function formularioLogin(?string $mensagem, string $ultimoEmail): void
    {
        ?>
        <section class="card formulario">
            <h2>Login</h2>
            <?php if ($mensagem): ?><p class="mensagem erro"><?= htmlspecialchars($mensagem) ?></p><?php endif; ?>

            <form method="POST" action="./?p=login">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($ultimoEmail) ?>" required>

                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>

                <button type="submit">Entrar</button>
            </form>
        </section>
        <?php
    }
}
