<?php

namespace Src\Services;

use Src\Domain\Repositories\IStatusProdutoRepository;
use Src\Core\HttpException;

class StatusProdutoService
{
    private IStatusProdutoRepository $repository;

    public function __construct(IStatusProdutoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(string $descricaoStatus): void
    {
        if (empty($descricaoStatus)) {
            throw new HttpException("Descrição do status é obrigatório", 400);
        }

        $this->repository->create($descricaoStatus);
    }

    public function list(): array
    {
        return $this->repository->list();
    }

    public function update(int $id, string $descricaoStatus): void
    {
        $statusProduto = $this->repository->findById($id);

        if (!$statusProduto) {
            throw new HttpException("Status não encontrado", 404);
        }

        if (empty($descricaoStatus)) {
            throw new HttpException("Descrição do status é obrigatório", 400);
        }

        $this->repository->update($id, $descricaoStatus);
    }

    public function delete(int $id): void
    {
        $statusProduto = $this->repository->findById($id);

        if (!$statusProduto) {
            throw new HttpException("Status não encontrado", 404);
        }

        $this->repository->delete($id);
    }
}

?>