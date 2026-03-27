<?php

namespace Src\Models;

class Endereco
{
    public function __construct(
        public int $codProduto,
        public string $descricaoProduto,
        public float $valorProduto,
        public int $statusId,
        public int $tipoPrazoGarantiaId,
        public int $tempoGarantia

    ) {}
}