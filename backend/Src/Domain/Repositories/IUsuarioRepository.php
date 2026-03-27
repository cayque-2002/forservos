<?php

namespace Src\Domain\Repositories;

interface IUsuarioRepository
{
    public function create(
        string $nome,
        string $email,
        string $senha,
        int $roleid
    ): void;

    public function findByEmail(string $email): ?array;
}

?>