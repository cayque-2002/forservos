<?php

namespace Tests\Fakes;

use Src\Domain\Repositories\IOrdemServicoRepository;

class FakeOrdemServicoRepository implements IOrdemServicoRepository
{
    public array $ordens = [];
    private int $autoIncrement = 1;

    public function create(
        int $numOs,
        int $situacaoOsId,
        int $clienteId,
        int $produtoId,
        int $cidadeId,
        ?string $observacao
    ): int {
        $ordem = [
            'id' => $this->autoIncrement++,
            'numos' => $numOs,
            'situacaoosid' => $situacaoOsId,
            'clienteid' => $clienteId,
            'produtoid' => $produtoId,
            'cidadeid' => $cidadeId,
            'observacao' => $observacao
        ];

        $this->ordens[] = $ordem;

        return $ordem['id'];
    }

    public function list(): array
    {
        return $this->ordens;
    }

    public function listDashboardHoje(): array
    {
        return $this->ordens;
    }

    public function findById(int $id): ?array
    {
        foreach ($this->ordens as $ordem) {
            if ($ordem['id'] === $id) {
                return $ordem;
            }
        }

        return null;
    }

    public function findByNumOs(int $numOs): ?array
    {
        foreach ($this->ordens as $ordem) {
            if ($ordem['numos'] === $numOs) {
                return $ordem;
            }
        }

        return null;
    }

    public function update(
        int $id,
        int $numOs,
        int $situacaoOsId,
        int $clienteId,
        int $produtoId,
        int $cidadeId,
        ?string $observacao
    ): void {
        foreach ($this->ordens as &$ordem) {
            if ($ordem['id'] === $id) {
                $ordem['numos'] = $numOs;
                $ordem['situacaoosid'] = $situacaoOsId;
                $ordem['clienteid'] = $clienteId;
                $ordem['produtoid'] = $produtoId;
                $ordem['cidadeid'] = $cidadeId;
                $ordem['observacao'] = $observacao;
                return;
            }
        }
    }

    public function delete(int $id): void
    {
        $this->ordens = array_values(array_filter(
            $this->ordens,
            fn($ordem) => $ordem['id'] !== $id
        ));
    }
}

?>