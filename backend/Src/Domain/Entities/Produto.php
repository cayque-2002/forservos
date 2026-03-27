<?php

namespace Src\Domain\Entities;

use Src\Core\HttpException;

class Produto
{
    private int $codProduto;
    private string $descricaoProduto;
    private float $valorProduto;
    private int $statusId;
    private int $tipoPrazoGarantiaId;
    private int $tempoGarantia;

    public function __construct(
        int $codProduto,
        string $descricaoProduto,
        float $valorProduto,
        int $statusId,
        int $tipoPrazoGarantiaId,
        int $tempoGarantia
    ) {
        if ($codProduto <= 0) {
            throw new HttpException("Código do produto inválido", 400);
        }

        if (empty(trim($descricaoProduto))) {
            throw new HttpException("Descrição do produto é obrigatória", 400);
        }

        if ($valorProduto <= 0) {
            throw new HttpException("Valor do produto inválido", 400);
        }

        if ($statusId <= 0) {
            throw new HttpException("Status do produto inválido", 400);
        }

        if ($tipoPrazoGarantiaId <= 0) {
            throw new HttpException("Tipo de prazo de garantia inválido", 400);
        }

        if ($tempoGarantia < 0) {
            throw new HttpException("Tempo de garantia inválido", 400);
        }

        $this->codProduto = $codProduto;
        $this->descricaoProduto = trim($descricaoProduto);
        $this->valorProduto = $valorProduto;
        $this->statusId = $statusId;
        $this->tipoPrazoGarantiaId = $tipoPrazoGarantiaId;
        $this->tempoGarantia = $tempoGarantia;
    }

    public function getCodProduto(): int { return $this->codProduto; }
    public function getDescricaoProduto(): string { return $this->descricaoProduto; }
    public function getValorProduto(): float { return $this->valorProduto; }
    public function getStatusId(): int { return $this->statusId; }
    public function getTipoPrazoGarantiaId(): int { return $this->tipoPrazoGarantiaId; }
    public function getTempoGarantia(): int { return $this->tempoGarantia; }
}

?>