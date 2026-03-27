<?php

namespace Src\Domain\Repositories;

interface IProdutoRepository
{
    public function create(int $codProduto, string $descricaoProduto, float $valorProduto, int $statusId, int $tipoPrazoGarantiaId, int $tempoGarantia): int;
    public function list(): array;
    public function findById(int $id): ?array;
    public function update(int $id, int $codProduto, string $descricaoProduto, float $valorProduto, int $statusId, int $tipoPrazoGarantiaId, int $tempoGarantia): void;
    public function delete(int $id): void;
}

?>