<?php

namespace Src\Services;

use Src\Core\HttpException;
use Src\Domain\Entities\OrdemServico;
use Src\Domain\Entities\OrdemServicoLog;
use Src\Domain\Repositories\IClienteRepository;
use Src\Domain\Repositories\IOrdemServicoLogRepository;
use Src\Domain\Repositories\IOrdemServicoRepository;

class OrdemServicoService
{
    public function __construct(
        private IOrdemServicoRepository $repository,
        private IOrdemServicoLogRepository $logRepository,
        private IClienteRepository $clienteRepository
    ) {}

    public function create(
        int $numOs,
        int $produtoId,
        int $cidadeId,
        ?string $observacao,
        array $clienteData,
        int $situacaoOsId = 1
    ): int {
        if ($this->repository->findByNumOs($numOs)) {
            throw new HttpException("Já existe ordem de serviço com este número", 400);
        }

        $cpf = preg_replace('/\D/', '', $clienteData['cpf'] ?? '');
        $cliente = $this->clienteRepository->findByCpf($cpf);

        if (!$cliente) {
            if (
                !isset($clienteData['nomeCliente']) ||
                !isset($clienteData['situacaoClienteId']) ||
                !isset($clienteData['enderecoId']) ||
                !isset($clienteData['numeroEndereco'])
            ) {
                throw new HttpException("Dados do cliente insuficientes para cadastro automático", 400);
            }

            $clienteId = $this->clienteRepository->create(
                $clienteData['nomeCliente'],
                $cpf,
                (int)$clienteData['situacaoClienteId'],
                (int)$clienteData['enderecoId'],
                (int)$clienteData['numeroEndereco'],
                $clienteData['complementoCliente'] ?? null
            );
        } else {
            $clienteId = (int)$cliente['id'];
        }

        $os = new OrdemServico(
            $numOs,
            $situacaoOsId,
            $clienteId,
            $produtoId,
            $cidadeId,
            $observacao
        );

        $ordemId = $this->repository->create(
            $os->getNumOs(),
            $os->getSituacaoOsId(),
            $os->getClienteId(),
            $os->getProdutoId(),
            $os->getCidadeId(),
            $os->getObservacao()
        );

        $log = new OrdemServicoLog($ordemId, 'CREATE', [
            'after' => [
                'numOs' => $os->getNumOs(),
                'situacaoOsId' => $os->getSituacaoOsId(),
                'clienteId' => $os->getClienteId(),
                'produtoId' => $os->getProdutoId(),
                'cidadeId' => $os->getCidadeId(),
                'observacao' => $os->getObservacao()
            ]
        ]);

        $this->logRepository->create(
            $log->getOrdemServicoId(),
            $log->getAcao(),
            $log->getDados()
        );

        return $ordemId;
    }

    public function list(): array
    {
        return $this->repository->list();
    }

    public function listDashboardHoje(): array
    {
        return $this->repository->listDashboardHoje();
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
        $before = $this->repository->findById($id);

        if (!$before) {
            throw new HttpException("Ordem de serviço não encontrada", 404);
        }

        $osComMesmoNumero = $this->repository->findByNumOs($numOs);
        if ($osComMesmoNumero && (int)$osComMesmoNumero['id'] !== $id) {
            throw new HttpException("Já existe ordem de serviço com este número", 400);
        }

        $os = new OrdemServico(
            $numOs,
            $situacaoOsId,
            $clienteId,
            $produtoId,
            $cidadeId,
            $observacao
        );

        $this->repository->update(
            $id,
            $os->getNumOs(),
            $os->getSituacaoOsId(),
            $os->getClienteId(),
            $os->getProdutoId(),
            $os->getCidadeId(),
            $os->getObservacao()
        );

        $after = $this->repository->findById($id);

        $log = new OrdemServicoLog($id, 'UPDATE', [
            'before' => $before,
            'after' => $after
        ]);

        $this->logRepository->create(
            $log->getOrdemServicoId(),
            $log->getAcao(),
            $log->getDados()
        );
    }

    public function delete(int $id): void
    {
        $before = $this->repository->findById($id);

        if (!$before) {
            throw new HttpException("Ordem de serviço não encontrada", 404);
        }

        $log = new OrdemServicoLog($id, 'DELETE', [
            'before' => $before
        ]);

        $this->logRepository->create(
            $log->getOrdemServicoId(),
            $log->getAcao(),
            $log->getDados()
        );

        $this->repository->delete($id);
    }
}

?>