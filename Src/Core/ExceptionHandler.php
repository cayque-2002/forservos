<?php

namespace Src\Core;

class ExceptionHandler
{
    public static function handle(\Throwable $e)
    {
        if ($e instanceof HttpException) {
            Response::error($e->getMessage(), $e->getStatusCode());
        }

        // erro inesperado
        Response::error("Erro interno do servidor", 500);
    }
}

?>