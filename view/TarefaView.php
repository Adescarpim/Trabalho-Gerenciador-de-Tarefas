<?php
namespace App\View;

use App\Util\Auth;

class TarefaView
{
    public static function listar(array $tarefas, array $usuarios, array $filtros): void
    {
        ?>
        <section class="card">
            <h2>Lista de Tarefas</h2>

            <form class="filtros" method="GET" action="./">
                <input type="hidden" name="p" value="tarefas">

                <label for="responsavel_id">Responsável</label>
                <select name="responsavel_id" id="responsavel_id">
                    <option value="">Todos</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= $usuario['id'] ?>" <?= ($filtros['responsavel_id'] == $usuario['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($usuario['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="">Todos</option>
                    <option value="pendente" <?= ($filtros['status'] === 'pendente') ? 'selected' : '' ?>>Pendente</option>
                    <option value="em andamento" <?= ($filtros['status'] === 'em andamento') ? 'selected' : '' ?>>Em andamento</option>
                    <option value="concluida" <?= ($filtros['status'] === 'concluida') ? 'selected' : '' ?>>Concluída</option>
                </select>

                <label for="data_limite">Data limite</label>
                <input type="date" name="data_limite" id="data_limite" value="<?= htmlspecialchars($filtros['data_limite']) ?>">

                <button type="submit">Filtrar</button>
                <a class="botao-secundario" href="./?p=tarefas">Limpar</a>
            </form>
        </section>

        <section class="lista-tarefas">
            <?php if (empty($tarefas)): ?>
                <article class="card">
                    <p>Nenhuma tarefa encontrada.</p>
                </article>
            <?php endif; ?>

            <?php foreach ($tarefas as $tarefa): ?>
                <article class="card tarefa">
                    <header>
                        <h3><?= htmlspecialchars($tarefa['titulo']) ?></h3>
                        <span class="status <?= str_replace(' ', '-', $tarefa['status']) ?>">
                            <?= htmlspecialchars($tarefa['status']) ?>
                        </span>
                    </header>
                    <p><?= htmlspecialchars($tarefa['descricao']) ?></p>
                    <p><strong>Responsável:</strong> <?= htmlspecialchars($tarefa['nome_responsavel']) ?></p>
                    <p><strong>Criador:</strong> <?= htmlspecialchars($tarefa['nome_criador']) ?></p>
                    <p><strong>Data limite:</strong> <?= htmlspecialchars($tarefa['data_limite']) ?></p>
                    <a class="botao" href="./?p=detalhes&id=<?= $tarefa['id'] ?>">Ver detalhes</a>
                </article>
            <?php endforeach; ?>
        </section>
        <?php
    }

    public static function formulario(array $usuarios, ?string $mensagem): void
    {
        ?>
        <section class="card formulario">
            <h2>Adicionar Tarefa</h2>
            <?php if ($mensagem): ?><p class="mensagem erro"><?= htmlspecialchars($mensagem) ?></p><?php endif; ?>

            <form method="POST" action="./?p=nova_tarefa">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" required>

                <label for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao" rows="5" required></textarea>

                <label for="data_limite">Data limite</label>
                <input type="date" name="data_limite" id="data_limite" required>

                <label for="responsavel_id">Responsável</label>
                <select name="responsavel_id" id="responsavel_id" required>
                    <option value="">Selecione</option>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= $usuario['id'] ?>" <?= (Auth::usuarioId() == $usuario['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($usuario['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Salvar tarefa</button>
            </form>
        </section>
        <?php
    }

    public static function detalhes(array $tarefa, array $comentarios, array $historico): void
    {
        $usuarioId = Auth::usuarioId();
        $podeAlterar = ($usuarioId == $tarefa['criador_id'] || $usuarioId == $tarefa['responsavel_id']);
        ?>
        <section class="card">
            <h2><?= htmlspecialchars($tarefa['titulo']) ?></h2>
            <p><?= htmlspecialchars($tarefa['descricao']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($tarefa['status']) ?></p>
            <p><strong>Responsável:</strong> <?= htmlspecialchars($tarefa['nome_responsavel']) ?></p>
            <p><strong>Criador:</strong> <?= htmlspecialchars($tarefa['nome_criador']) ?></p>
            <p><strong>Data limite:</strong> <?= htmlspecialchars($tarefa['data_limite']) ?></p>

            <?php if ($podeAlterar): ?>
                <form class="form-linha" method="POST" action="./?p=atualizar_status">
                    <input type="hidden" name="tarefa_id" value="<?= $tarefa['id'] ?>">
                    <label for="status">Atualizar status</label>
                    <select name="status" id="status">
                        <option value="pendente" <?= $tarefa['status'] === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                        <option value="em andamento" <?= $tarefa['status'] === 'em andamento' ? 'selected' : '' ?>>Em andamento</option>
                        <option value="concluida" <?= $tarefa['status'] === 'concluida' ? 'selected' : '' ?>>Concluída</option>
                    </select>
                    <button type="submit">Atualizar</button>
                </form>
            <?php else: ?>
                <p class="mensagem">Você pode visualizar esta tarefa, mas não pode alterar o status.</p>
            <?php endif; ?>
        </section>

        <section class="card formulario">
            <h3>Comentários</h3>
            <form method="POST" action="./?p=adicionar_comentario">
                <input type="hidden" name="tarefa_id" value="<?= $tarefa['id'] ?>">
                <label for="comentario">Novo comentário</label>
                <textarea name="comentario" id="comentario" rows="3" required></textarea>
                <button type="submit">Comentar</button>
            </form>

            <?php foreach ($comentarios as $comentario): ?>
                <article class="comentario">
                    <p><?= htmlspecialchars($comentario['comentario']) ?></p>
                    <small>Por <?= htmlspecialchars($comentario['nome_usuario']) ?> em <?= htmlspecialchars($comentario['data_comentario']) ?></small>
                </article>
            <?php endforeach; ?>
        </section>

        <section class="card">
            <h3>Histórico de Alterações</h3>
            <?php if (empty($historico)): ?>
                <p>Nenhum histórico registrado.</p>
            <?php endif; ?>
            <?php foreach ($historico as $item): ?>
                <article class="historico">
                    <p><?= htmlspecialchars($item['descricao_alteracao']) ?></p>
                    <small>Por <?= htmlspecialchars($item['nome_usuario']) ?> em <?= htmlspecialchars($item['data_alteracao']) ?></small>
                </article>
            <?php endforeach; ?>
        </section>
        <?php
    }
}
