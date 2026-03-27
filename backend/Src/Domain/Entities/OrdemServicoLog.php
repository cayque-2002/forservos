<?php

namespace Src\Domain\Entities;

use Src\Core\HttpException;

class OrdemServicoLog
{
    private int $ordemServicoId;
    private string $acao;
    private array $dados;

    public function __construct(int $ordemServicoId, string $acao, array $dados = [])
    {
        if ($ordemServicoId <= 0) {
            throw new HttpException("Ordem de serviço inválida para log", 400);
        }

        if (empty(trim($acao))) {
            throw new HttpException("Ação do log é obrigatória", 400);
        }

        $this->ordemServicoId = $ordemServicoId;
        $this->acao = strtoupper(trim($acao));
        $this->dados = $dados;
    }

    public function getOrdemServicoId(): int { return $this->ordemServicoId; }
    public function getAcao(): string { return $this->acao; }
    public function getDados(): array { return $this->dados; }
}

?>