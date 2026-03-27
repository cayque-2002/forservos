<?php

namespace Src\Domain\Repositories;

interface IOrdemServicoRepository
{
    public function create(int $numOs, int $situacaoOsId, int $clienteId, int $produtoId, int $cidadeId, ?string $observacao): int;
    public function list(): array;
    public function listDashboardHoje(): array;
    public function findById(int $id): ?array;
    public function findByNumOs(int $numOs): ?array;
    public function update(int $id, int $numOs, int $situacaoOsId, int $clienteId, int $produtoId, int $cidadeId, ?string $observacao): void;
    public function delete(int $id): void;
}

?>