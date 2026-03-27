<?php

namespace Src\Services;

use Src\Domain\Repositories\ISituacaoClientesRepository;
use Src\Core\HttpException;

class SituacaoClientesService
{
    private ISituacaoClientesRepository $repository;

    public function __construct(ISituacaoClientesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(string $descricaoSituacao): void
    {
        if (empty($descricaoSituacao)) {
            throw new HttpException("Descrição da situação é obrigatória", 400);
        }

        $this->repository->create($descricaoSituacao);
    }

    public function list(): array
    {
        return $this->repository->list();
    }

    public function update(int $id, string $descricaoSituacao): void
    {
        $situacaoCliente = $this->repository->findById($id);

        if (!$situacaoCliente) {
            throw new HttpException("Situação não encontrada", 404);
        }

        if (empty($descricaoSituacao)) {
            throw new HttpException("Descrição da situação é obrigatória", 400);
        }

        $this->repository->update($id, $descricaoSituacao);
    }

    public function delete(int $id): void
    {
        $situacaoCliente = $this->repository->findById($id);

        if (!$situacaoCliente) {
            throw new HttpException("Situação não encontrada", 404);
        }

        $this->repository->delete($id);
    }
}

?>