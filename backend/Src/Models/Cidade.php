<?php

namespace Src\Models;

class Cidade
{
    public function __construct(
        public ?int $id,
        public string $nomeCidade,        
        public string $estadoId
    ) {}
}