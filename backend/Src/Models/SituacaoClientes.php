<?php

namespace Src\Models;

class SituacaoClientes
{
    public function __construct(
        public ?int $id,
        public string $descricaoSituacao
    ) {}
}