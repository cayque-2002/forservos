<?php

namespace Src\Services;

use Src\Domain\Repositories\IRoleUsuariosRepository;
use Src\Core\HttpException;

class RoleUsuariosService
{
    private IRoleUsuariosRepository $repository;

    public function __construct(IRoleUsuariosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(string $nomeRole): void
    {
        if (empty($nomeRole)) {
            throw new HttpException("Nome da role é obrigatório", 400);
        }

        $this->repository->create($nomeRole);
    }

    public function list(): array
    {
        return $this->repository->list();
    }

    public function update(int $id, string $nomeRole): void
    {
        $role = $this->repository->findById($id);

        if (!$role) {
            throw new HttpException("Role não encontrada", 404);
        }

        if (empty($nomeRole)) {
            throw new HttpException("Nome da role é obrigatório", 400);
        }

        $this->repository->update($id, $nomeRole);
    }

    public function delete(int $id): void
    {
        $role = $this->repository->findById($id);

        if (!$role) {
            throw new HttpException("Role não encontrada", 404);
        }

        $this->repository->delete($id);
    }
}

?>