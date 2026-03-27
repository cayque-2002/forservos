<?php

namespace Tests\Fakes;

use Src\Domain\Repositories\IOrdemServicoLogRepository;

class FakeOrdemServicoLogRepository implements IOrdemServicoLogRepository
{
    public array $logs = [];

    public function create(int $ordemServicoId, string $acao, array $dados): void
    {
        $this->logs[] = [
            'ordemservicoid' => $ordemServicoId,
            'acao' => $acao,
            'dados' => $dados
        ];
    }

    public function listByOrdemServicoId(int $ordemServicoId): array
    {
        return array_values(array_filter(
            $this->logs,
            fn($log) => $log['ordemservicoid'] === $ordemServicoId
        ));
    }
}