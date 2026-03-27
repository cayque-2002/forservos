<?php

namespace Src\Models;

class Endereco
{
    public function __construct(
        public string $logradouro,
        public string $bairro,
        public string $cep,
        public int $cidadeId,
        public ?string $complementoEndereco
    ) {}
}