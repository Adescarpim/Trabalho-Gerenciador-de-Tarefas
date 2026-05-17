<?php
namespace App\Controller;

use App\Dal\ComentarioDao;
use App\Dal\HistoricoDao;
use App\Model\Comentario;
use App\Model\Historico;
use App\Util\Auth;
use App\Util\Functions;

class ComentarioController
{
    public static function cadastrar(): void
    {
        Auth::exigirLogin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tarefaId = (int)($_POST['tarefa_id'] ?? 0);
            $textoComentario = Functions::limparEntrada($_POST['comentario'] ?? '');

            if ($tarefaId > 0 && $textoComentario !== '') {
                $comentario = new Comentario(null, $tarefaId, Auth::usuarioId(), $textoComentario);
                ComentarioDao::cadastrar($comentario);
                HistoricoDao::registrar(new Historico(null, $tarefaId, Auth::usuarioId(), "Comentário adicionado."));
            }

            Functions::voltarParaDetalhes($tarefaId);
        }

        Functions::redirecionar('tarefas');
    }
}
