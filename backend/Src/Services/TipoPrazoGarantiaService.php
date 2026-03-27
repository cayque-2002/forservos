<?php

namespace Src\Services;

use Src\Domain\Repositories\ITipoPrazoGarantiaRepository;
use Src\Core\HttpException;

class TipoPrazoGarantiaService
{
    private ITipoPrazoGarantiaRepository $repository;

    public function __construct(ITipoPrazoGarantiaRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(string $descricaoPrazo): void
    {
        if (empty($descricaoPrazo)) {
            throw new HttpException("Descrição do prazo é obrigatório", 400);
        }

        $this->repository->create($descricaoPrazo);
    }

    public function list(): array
    {
        return $this->repository->list();
    }

    public function update(int $id, string $descricaoPrazo): void
    {
        $tipoPrazo = $this->repository->findById($id);

        if (!$tipoPrazo) {
            throw new HttpException("Prazo não encontrado", 404);
        }

        if (empty($descricaoPrazo)) {
            throw new HttpException("Descrição do prazo é obrigatório", 400);
        }

        $this->repository->update($id, $descricaoPrazo);
    }

    public function delete(int $id): void
    {
        $tipoPrazo = $this->repository->findById($id);

        if (!$tipoPrazo) {
            throw new HttpException("Prazo não encontrado", 404);
        }

        $this->repository->delete($id);
    }
}

?>