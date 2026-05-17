<?php
namespace App\Model;

class Historico
{
    private ?int $id;
    private int $tarefaId;
    private int $usuarioId;
    private string $descricaoAlteracao;

    public function __construct(?int $id, int $tarefaId, int $usuarioId, string $descricaoAlteracao)
    {
        $this->id = $id;
        $this->tarefaId = $tarefaId;
        $this->usuarioId = $usuarioId;
        $this->descricaoAlteracao = $descricaoAlteracao;
    }

    public function getId(): ?int { return $this->id; }
    public function getTarefaId(): int { return $this->tarefaId; }
    public function getUsuarioId(): int { return $this->usuarioId; }
    public function getDescricaoAlteracao(): string { return $this->descricaoAlteracao; }
}
