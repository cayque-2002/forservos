<?php

namespace Src\Models;

class Endereco
{
    public function __construct(
        public string $nomeCliente,
        public string $cpf,
        public int $situacaoClienteId,
        public int $enderecoId,
        public int $numeroEndereco,
        public ?string $complementoCliente
    ) {}
}