<?php

namespace Src\Models;

class StatusProduto
{
    public function __construct(
        public ?int $id,
        public string $descricaoStatus
    ) {}
}