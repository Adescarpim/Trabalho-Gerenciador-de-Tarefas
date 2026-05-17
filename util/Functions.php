<?php
namespace App\Util;

class Functions
{
    public static function limparEntrada(string $valor): string
    {
        return trim(strip_tags($valor));
    }

    public static function redirecionar(string $pagina): void
    {
        header("Location: ./?p=" . $pagina);
        exit;
    }

    public static function voltarParaDetalhes(int $id): void
    {
        header("Location: ./?p=detalhes&id=" . $id);
        exit;
    }
}
