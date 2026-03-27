<?php

namespace Src\Services;

use Src\Domain\Repositories\IOrdemServicoLogRepository;

class OrdemServicoLogService
{
    public function __construct(private IOrdemServicoLogRepository $repository) {}

    public function listByOrdemServicoId(int $ordemServicoId): array
    {
        return $this->repository->listByOrdemServicoId($ordemServicoId);
    }
}

?>