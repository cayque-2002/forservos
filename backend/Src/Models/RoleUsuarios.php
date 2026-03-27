<?php

namespace Src\Models;

class RoleUsuarios
{
    public function __construct(
        public ?int $id,
        public string $nomeRole
    ) {}
}