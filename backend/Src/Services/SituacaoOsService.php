<?php

namespace Src\Services;

use Src\Domain\Repositories\ISituacaoOsRepository;
use Src\Core\HttpException;

class SituacaoOsService
{
    private ISituacaoOsRepository $repository;

    public function __construct(ISituacaoOsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(string $descricaoSituacaoOs): void
    {
        if (empty($descricaoSituacaoOs)) {
            throw new HttpException("Descrição da situação Os é obrigatória", 400);
        }

        $this->repository->create($descricaoSituacaoOs);
    }

    public function list(): array
    {
        return $this->repository->list();
    }

    public function update(int $id, string $descricaoSituacaoOs): void
    {
        $situacaoOs = $this->repository->findById($id);

        if (!$situacaoOs) {
            throw new HttpException("Situação Os não encontrada", 404);
        }

        if (empty($descricaoSituacaoOs)) {
            throw new HttpException("Descrição da situação Os é obrigatória", 400);
        }

        $this->repository->update($id, $descricaoSituacaoOs);
    }

    public function delete(int $id): void
    {
        $situacaoOs = $this->repository->findById($id);

        if (!$situacaoOs) {
            throw new HttpException("Situação Os não encontrada", 404);
        }

        $this->repository->delete($id);
    }
}

?>