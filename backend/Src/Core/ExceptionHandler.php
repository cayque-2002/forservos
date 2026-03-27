<?php

namespace Src\Core;

use Throwable;

class ExceptionHandler
{
//manter aqui para debugs
    // public static function handle(Throwable $e)
    // {
    //     http_response_code(500);
    //     header('Content-Type: application/json');

    //     echo json_encode([
    //         "success" => false,
    //         "data" => null,
    //         "error" => [
    //             "message" => $e->getMessage(),
    //             "code" => $e->getCode(),
    //             "file" => $e->getFile(),
    //             "line" => $e->getLine()
    //         ]
    //     ]);
    // }

   public static function handle(\Throwable $e): void
    {
        if ($e instanceof \Src\Core\HttpException) {
            Response::error($e->getMessage(), $e->getStatusCode());
            return;
        }

        Response::error("Erro interno do servidor", 500);
    }
}

?>