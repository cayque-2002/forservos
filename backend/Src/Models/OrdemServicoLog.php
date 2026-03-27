<?php

namespace Src\Models;

class Endereco
{
    public function __construct(
        public int $ordemServicoId,
        public string $acao,
        public array $dados

    ) {}
}