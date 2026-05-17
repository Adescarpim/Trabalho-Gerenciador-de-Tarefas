/* Nome: Ademir José Wilsek Scarpim - RGM: 37063758 */
<?php
require_once "./Autoload.php";

use App\Controller\UsuarioController;
use App\Controller\TarefaController;
use App\Controller\ComentarioController;

session_start();
$page = $_GET["p"] ?? "home";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="./assets/style.css">
</head>
<body>
    <?php require_once "./menu.php"; ?>

    <main class="container">
        <?php
            match($page) {
                "home" => require_once("./view/home.php"),
                "login" => UsuarioController::login(),
                "cadastro" => UsuarioController::cadastrar(),
                "logout" => UsuarioController::logout(),
                "tarefas", "list" => TarefaController::listar(),
                "nova_tarefa", "cad" => TarefaController::cadastrar(),
                "detalhes" => TarefaController::detalhar(),
                "atualizar_status" => TarefaController::atualizarStatus(),
                "adicionar_comentario" => ComentarioController::cadastrar(),
                default => require_once("./view/404.php")
            };
        ?>
    </main>

    <footer class="rodape">
        <p>Sistema desenvolvido em PHP POO, MySQL e PDO.</p>
    </footer>
</body>
</html>
