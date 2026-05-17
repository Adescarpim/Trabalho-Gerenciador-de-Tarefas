<?php
namespace App\Dal;

use App\Model\Comentario;
use PDO;

class ComentarioDao
{
    public static function cadastrar(Comentario $comentario): bool
    {
        $sql = "INSERT INTO comentarios (tarefa_id, usuario_id, comentario)
                VALUES (:tarefa_id, :usuario_id, :comentario)";
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(':tarefa_id', $comentario->getTarefaId(), PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $comentario->getUsuarioId(), PDO::PARAM_INT);
        $stmt->bindValue(':comentario', $comentario->getComentario());
        return $stmt->execute();
    }

    public static function listarPorTarefa(int $tarefaId): array
    {
        $sql = "SELECT c.*, u.nome AS nome_usuario
                FROM comentarios c
                INNER JOIN usuarios u ON u.id = c.usuario_id
                WHERE c.tarefa_id = :tarefa_id
                ORDER BY c.data_comentario ASC";
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(':tarefa_id', $tarefaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
