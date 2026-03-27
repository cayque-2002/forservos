<?php

namespace Src\Models;

class TipoPrazoGarantia
{
    public function __construct(
        public ?int $id,
        public string $descricaoPrazo
    ) {}
}