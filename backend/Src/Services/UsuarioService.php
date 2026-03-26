<?php

namespace Src\Services;

use Src\Domain\Repositories\IUsuarioRepository;
use Src\Domain\Entities\Usuario;

class UsuarioService
{
    private IUsuarioRepository $repository;

    public function __construct(IUsuarioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($nome, $email, $senha, $roleId)
    {
        // cria entidade (validações principais na propria entidade)
        $usuario = new Usuario($nome, $email, $senha, $roleId);

        $this->repository->create(
            $usuario->getNome(),
            $usuario->getEmail(),
            $usuario->getSenha(),
            $usuario->getRoleId()
        );
    }
}

?>