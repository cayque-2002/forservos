<?php

namespace Src\Models;

class SituacaoOs
{
    public function __construct(
        public ?int $id,
        public string $descricaoSituacaoOs
    ) {}
}