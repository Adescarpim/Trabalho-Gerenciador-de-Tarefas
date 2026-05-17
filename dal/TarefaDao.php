<?php
namespace App\Dal;

use App\Model\Tarefa;
use PDO;

class TarefaDao
{
    public static function cadastrar(Tarefa $tarefa): bool
    {
        $sql = "INSERT INTO tarefas (titulo, descricao, data_limite, status, criador_id, responsavel_id)
                VALUES (:titulo, :descricao, :data_limite, :status, :criador_id, :responsavel_id)";
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(':titulo', $tarefa->getTitulo());
        $stmt->bindValue(':descricao', $tarefa->getDescricao());
        $stmt->bindValue(':data_limite', $tarefa->getDataLimite());
        $stmt->bindValue(':status', $tarefa->getStatus());
        $stmt->bindValue(':criador_id', $tarefa->getCriadorId(), PDO::PARAM_INT);
        $stmt->bindValue(':responsavel_id', $tarefa->getResponsavelId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public static function ultimoId(): int
    {
        return (int) Conn::getConn()->lastInsertId();
    }

    public static function listar(array $filtros = []): array
    {
        $sql = "SELECT t.*, criador.nome AS nome_criador, responsavel.nome AS nome_responsavel
                FROM tarefas t
                INNER JOIN usuarios criador ON criador.id = t.criador_id
                INNER JOIN usuarios responsavel ON responsavel.id = t.responsavel_id
                WHERE 1=1";

        $parametros = [];

        if (!empty($filtros['responsavel_id'])) {
            $sql .= " AND t.responsavel_id = :responsavel_id";
            $parametros[':responsavel_id'] = (int) $filtros['responsavel_id'];
        }

        if (!empty($filtros['status'])) {
            $sql .= " AND t.status = :status";
            $parametros[':status'] = $filtros['status'];
        }

        if (!empty($filtros['data_limite'])) {
            $sql .= " AND t.data_limite = :data_limite";
            $parametros[':data_limite'] = $filtros['data_limite'];
        }

        $sql .= " ORDER BY t.data_limite ASC, t.id DESC";
        $stmt = Conn::getConn()->prepare($sql);

        foreach ($parametros as $campo => $valor) {
            $stmt->bindValue($campo, $valor);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscarPorId(int $id): ?array
    {
        $sql = "SELECT t.*, criador.nome AS nome_criador, responsavel.nome AS nome_responsavel
                FROM tarefas t
                INNER JOIN usuarios criador ON criador.id = t.criador_id
                INNER JOIN usuarios responsavel ON responsavel.id = t.responsavel_id
                WHERE t.id = :id LIMIT 1";
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $tarefa = $stmt->fetch(PDO::FETCH_ASSOC);
        return $tarefa ?: null;
    }

    public static function atualizarStatus(int $id, string $status): bool
    {
        $sql = "UPDATE tarefas SET status = :status WHERE id = :id";
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
