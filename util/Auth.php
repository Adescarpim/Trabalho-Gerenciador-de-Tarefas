<?php
namespace App\Util;

class Auth
{
    public static function estaLogado(): bool
    {
        return isset($_SESSION['usuario_id']);
    }

    public static function exigirLogin(): void
    {
        if (!self::estaLogado()) {
            header("Location: ./?p=login");
            exit;
        }
    }

    public static function login(int $id, string $nome, string $email): void
    {
        $_SESSION['usuario_id'] = $id;
        $_SESSION['usuario_nome'] = $nome;
        $_SESSION['usuario_email'] = $email;
    }

    public static function logout(): void
    {
        session_unset();
        session_destroy();
    }

    public static function usuarioId(): ?int
    {
        return $_SESSION['usuario_id'] ?? null;
    }

    public static function usuarioNome(): string
    {
        return $_SESSION['usuario_nome'] ?? '';
    }
}
