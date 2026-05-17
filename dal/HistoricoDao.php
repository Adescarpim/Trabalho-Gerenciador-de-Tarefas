<?php
namespace App\Dal;

use App\Model\Historico;
use PDO;

class HistoricoDao
{
    public static function registrar(Historico $historico): bool
    {
        $sql = "INSERT INTO historico_alteracoes (tarefa_id, usuario_id, descricao_alteracao)
                VALUES (:tarefa_id, :usuario_id, :descricao_alteracao)";
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(':tarefa_id', $historico->getTarefaId(), PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $historico->getUsuarioId(), PDO::PARAM_INT);
        $stmt->bindValue(':descricao_alteracao', $historico->getDescricaoAlteracao());
        return $stmt->execute();
    }

    public static function listarPorTarefa(int $tarefaId): array
    {
        $sql = "SELECT h.*, u.nome AS nome_usuario
                FROM historico_alteracoes h
                INNER JOIN usuarios u ON u.id = h.usuario_id
                WHERE h.tarefa_id = :tarefa_id
                ORDER BY h.data_alteracao DESC";
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(':tarefa_id', $tarefaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
