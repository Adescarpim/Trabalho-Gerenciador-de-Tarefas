<?php
namespace App\Controller;

use App\Dal\UsuarioDao;
use App\Model\Usuario;
use App\Util\Auth;
use App\Util\Functions;
use App\View\UsuarioView;

class UsuarioController
{
    public static function cadastrar(): void
    {
        $mensagem = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = Functions::limparEntrada($_POST['nome'] ?? '');
            $email = Functions::limparEntrada($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';

            if ($nome === '' || $email === '' || $senha === '') {
                $mensagem = "Preencha todos os campos.";
            } elseif (UsuarioDao::buscarPorEmail($email)) {
                $mensagem = "Este e-mail já está cadastrado.";
            } else {
                $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);
                $usuario = new Usuario(null, $nome, $email, $senhaCriptografada);
                UsuarioDao::cadastrar($usuario);
                $mensagem = "Usuário cadastrado com sucesso. Agora faça login.";
            }
        }

        UsuarioView::formularioCadastro($mensagem);
    }

    public static function login(): void
    {
        $mensagem = null;
        $ultimoEmail = $_COOKIE['ultimo_email'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = Functions::limparEntrada($_POST['email'] ?? '');
            $senha = $_POST['senha'] ?? '';
            $usuario = UsuarioDao::buscarPorEmail($email);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                Auth::login((int)$usuario['id'], $usuario['nome'], $usuario['email']);
                setcookie('ultimo_email', $email, time() + 60 * 60 * 24 * 7);
                Functions::redirecionar('tarefas');
            } else {
                $mensagem = "E-mail ou senha inválidos.";
            }
        }

        UsuarioView::formularioLogin($mensagem, $ultimoEmail);
    }

    public static function logout(): void
    {
        Auth::logout();
        header("Location: ./?p=login");
        exit;
    }
}
