<?php

namespace Src\Models;

class Endereco
{
    public function __construct(
        public int $numOs,
        public int $situacaoOsId,
        public int $clienteId,
        public int $produtoId,
        public int $cidadeId,
        public ?string $observacao

    ) {}
}