<?php
namespace App\Controller;

use App\Dal\TarefaDao;
use App\Dal\UsuarioDao;
use App\Dal\ComentarioDao;
use App\Dal\HistoricoDao;
use App\Model\Tarefa;
use App\Model\Historico;
use App\Util\Auth;
use App\Util\Functions;
use App\View\TarefaView;

class TarefaController
{
    public static function listar(): void
    {
        Auth::exigirLogin();

        $filtros = [
            'responsavel_id' => $_GET['responsavel_id'] ?? '',
            'status' => $_GET['status'] ?? '',
            'data_limite' => $_GET['data_limite'] ?? ''
        ];

        $tarefas = TarefaDao::listar($filtros);
        $usuarios = UsuarioDao::listar();
        TarefaView::listar($tarefas, $usuarios, $filtros);
    }

    public static function cadastrar(): void
    {
        Auth::exigirLogin();
        $mensagem = null;
        $usuarios = UsuarioDao::listar();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = Functions::limparEntrada($_POST['titulo'] ?? '');
            $descricao = Functions::limparEntrada($_POST['descricao'] ?? '');
            $dataLimite = Functions::limparEntrada($_POST['data_limite'] ?? '');
            $responsavelId = (int)($_POST['responsavel_id'] ?? 0);

            if ($titulo === '' || $descricao === '' || $dataLimite === '' || $responsavelId <= 0) {
                $mensagem = "Preencha todos os campos da tarefa.";
            } else {
                $tarefa = new Tarefa(null, $titulo, $descricao, $dataLimite, 'pendente', Auth::usuarioId(), $responsavelId);
                TarefaDao::cadastrar($tarefa);
                $tarefaId = TarefaDao::ultimoId();
                HistoricoDao::registrar(new Historico(null, $tarefaId, Auth::usuarioId(), "Tarefa criada."));
                Functions::redirecionar('tarefas');
            }
        }

        TarefaView::formulario($usuarios, $mensagem);
    }

    public static function detalhar(): void
    {
        Auth::exigirLogin();

        $id = (int)($_GET['id'] ?? 0);
        $tarefa = TarefaDao::buscarPorId($id);

        if (!$tarefa) {
            require_once "./view/404.php";
            return;
        }

        $comentarios = ComentarioDao::listarPorTarefa($id);
        $historico = HistoricoDao::listarPorTarefa($id);
        TarefaView::detalhes($tarefa, $comentarios, $historico);
    }

    public static function atualizarStatus(): void
    {
        Auth::exigirLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Functions::redirecionar('tarefas');
        }

        $tarefaId = (int)($_POST['tarefa_id'] ?? 0);
        $novoStatus = Functions::limparEntrada($_POST['status'] ?? '');
        $statusPermitidos = ['pendente', 'em andamento', 'concluida'];
        $tarefa = TarefaDao::buscarPorId($tarefaId);

        if (!$tarefa || !in_array($novoStatus, $statusPermitidos)) {
            Functions::redirecionar('tarefas');
        }

        $usuarioId = Auth::usuarioId();
        $podeAlterar = ($usuarioId == $tarefa['criador_id'] || $usuarioId == $tarefa['responsavel_id']);

        if ($podeAlterar) {
            TarefaDao::atualizarStatus($tarefaId, $novoStatus);
            HistoricoDao::registrar(new Historico(null, $tarefaId, $usuarioId, "Status alterado para: " . $novoStatus));
        }

        Functions::voltarParaDetalhes($tarefaId);
    }
}
