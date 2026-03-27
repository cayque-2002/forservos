<?php

namespace Src\Services;

use Src\Domain\Entities\Produto;
use Src\Domain\Repositories\IProdutoRepository;
use Src\Core\HttpException;

class ProdutoService
{
    public function __construct(private IProdutoRepository $repository) {}

    public function create(int $codProduto, string $descricaoProduto, float $valorProduto, int $statusId, int $tipoPrazoGarantiaId, int $tempoGarantia): int
    {
        $produto = new Produto($codProduto, $descricaoProduto, $valorProduto, $statusId, $tipoPrazoGarantiaId, $tempoGarantia);

        return $this->repository->create(
            $produto->getCodProduto(),
            $produto->getDescricaoProduto(),
            $produto->getValorProduto(),
            $produto->getStatusId(),
            $produto->getTipoPrazoGarantiaId(),
            $produto->getTempoGarantia()
        );
    }

    public function list(): array
    {
        return $this->repository->list();
    }

    public function update(int $id, int $codProduto, string $descricaoProduto, float $valorProduto, int $statusId, int $tipoPrazoGarantiaId, int $tempoGarantia): void
    {
        if (!$this->repository->findById($id)) {
            throw new HttpException("Produto não encontrado", 404);
        }

        $produto = new Produto($codProduto, $descricaoProduto, $valorProduto, $statusId, $tipoPrazoGarantiaId, $tempoGarantia);

        $this->repository->update(
            $id,
            $produto->getCodProduto(),
            $produto->getDescricaoProduto(),
            $produto->getValorProduto(),
            $produto->getStatusId(),
            $produto->getTipoPrazoGarantiaId(),
            $produto->getTempoGarantia()
        );
    }

    public function delete(int $id): void
    {
        if (!$this->repository->findById($id)) {
            throw new HttpException("Produto não encontrado", 404);
        }

        $this->repository->delete($id);
    }
}

?>