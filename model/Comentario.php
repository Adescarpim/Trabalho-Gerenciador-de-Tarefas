<?php
namespace App\Model;

class Comentario
{
    private ?int $id;
    private int $tarefaId;
    private int $usuarioId;
    private string $comentario;

    public function __construct(?int $id, int $tarefaId, int $usuarioId, string $comentario)
    {
        $this->id = $id;
        $this->tarefaId = $tarefaId;
        $this->usuarioId = $usuarioId;
        $this->comentario = $comentario;
    }

    public function getId(): ?int { return $this->id; }
    public function getTarefaId(): int { return $this->tarefaId; }
    public function getUsuarioId(): int { return $this->usuarioId; }
    public function getComentario(): string { return $this->comentario; }
}
