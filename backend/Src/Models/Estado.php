<?php

namespace Src\Models;

class Estado
{
    public function __construct(
        public ?int $id,
        public string $nomeEstado,        
        public string $uf
    ) {}
}