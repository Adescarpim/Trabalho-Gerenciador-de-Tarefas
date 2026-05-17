<?php
namespace App\Dal;

use PDO;
use PDOException;

class Conn
{
    private static string $host = "localhost";
    private static string $dbname = "gerenciador_tarefas";
    private static string $user = "root";
    private static string $password = "";
    private static ?PDO $conn = null;

    public static function getConn(): PDO
    {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8mb4",
                    self::$user,
                    self::$password
                );
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $erro) {
                die("Erro ao conectar com o banco de dados: " . $erro->getMessage());
            }
        }
        return self::$conn;
    }
}
