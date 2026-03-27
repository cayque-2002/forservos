<?php

namespace Src\Domain\Repositories;

interface IOrdemServicoLogRepository
{
    public function create(int $ordemServicoId, string $acao, array $dados): void;
    public function listByOrdemServicoId(int $ordemServicoId): array;
}

?>