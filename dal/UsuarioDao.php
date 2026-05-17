<?php
namespace App\Dal;

use App\Model\Usuario;
use PDO;

class UsuarioDao
{
    public static function cadastrar(Usuario $usuario): bool
    {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(':nome', $usuario->getNome());
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->bindValue(':senha', $usuario->getSenha());
        return $stmt->execute();
    }

    public static function buscarPorEmail(string $email): ?array
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario ?: null;
    }

    public static function buscarPorId(int $id): ?array
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = Conn::getConn()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $usuario ?: null;
    }

    public static function listar(): array
    {
        $sql = "SELECT id, nome, email FROM usuarios ORDER BY nome ASC";
        $stmt = Conn::getConn()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
