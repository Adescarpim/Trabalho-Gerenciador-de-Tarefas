<?php
namespace App\Model;

class Tarefa
{
    private ?int $id;
    private string $titulo;
    private string $descricao;
    private string $dataLimite;
    private string $status;
    private int $criadorId;
    private int $responsavelId;

    public function __construct(?int $id, string $titulo, string $descricao, string $dataLimite, string $status, int $criadorId, int $responsavelId)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->dataLimite = $dataLimite;
        $this->status = $status;
        $this->criadorId = $criadorId;
        $this->responsavelId = $responsavelId;
    }

    public function getId(): ?int { return $this->id; }
    public function getTitulo(): string { return $this->titulo; }
    public function getDescricao(): string { return $this->descricao; }
    public function getDataLimite(): string { return $this->dataLimite; }
    public function getStatus(): string { return $this->status; }
    public function getCriadorId(): int { return $this->criadorId; }
    public function getResponsavelId(): int { return $this->responsavelId; }
}
