<?php

namespace Src\Models;

class Usuario
{
    public function __construct(
        public ?int $id,
        public string $nome,        
        public string $email,
        public string $senha,
        public int $roleid,
        public bool $ativo = true
    ) {}
}