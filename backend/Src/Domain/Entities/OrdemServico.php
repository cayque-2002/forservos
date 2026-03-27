<?php

namespace Src\Domain\Entities;

use Src\Core\HttpException;

class OrdemServico
{
    private int $numOs;
    private int $situacaoOsId;
    private int $clienteId;
    private int $produtoId;
    private int $cidadeId;
    private ?string $observacao;

    public function __construct(
        int $numOs,
        int $situacaoOsId,
        int $clienteId,
        int $produtoId,
        int $cidadeId,
        ?string $observacao = null
    ) {
        if ($numOs <= 0) {
            throw new HttpException("Número da ordem de serviço inválido", 400);
        }

        if ($situacaoOsId <= 0) {
            throw new HttpException("Situação da ordem de serviço inválida", 400);
        }

        if ($clienteId <= 0) {
            throw new HttpException("Cliente inválido", 400);
        }

        if ($produtoId <= 0) {
            throw new HttpException("Produto inválido", 400);
        }

        if ($cidadeId <= 0) {
            throw new HttpException("Cidade inválida", 400);
        }

        $this->numOs = $numOs;
        $this->situacaoOsId = $situacaoOsId;
        $this->clienteId = $clienteId;
        $this->produtoId = $produtoId;
        $this->cidadeId = $cidadeId;
        $this->observacao = $observacao;
    }

    public function getNumOs(): int { return $this->numOs; }
    public function getSituacaoOsId(): int { return $this->situacaoOsId; }
    public function getClienteId(): int { return $this->clienteId; }
    public function getProdutoId(): int { return $this->produtoId; }
    public function getCidadeId(): int { return $this->cidadeId; }
    public function getObservacao(): ?string { return $this->observacao; }
}

?>