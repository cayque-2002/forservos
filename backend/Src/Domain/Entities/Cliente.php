<?php

namespace Src\Domain\Entities;

use Src\Core\HttpException;

class Cliente
{
    private string $nomeCliente;
    private string $cpf;
    private int $situacaoClienteId;
    private int $enderecoId;
    private int $numeroEndereco;
    private ?string $complementoCliente;

    public function __construct(
        string $nomeCliente,
        string $cpf,
        int $situacaoClienteId,
        int $enderecoId,
        int $numeroEndereco,
        ?string $complementoCliente = null
    ) {
        $this->setNomeCliente($nomeCliente);
        $this->setCpf($cpf);
        $this->setSituacaoClienteId($situacaoClienteId);
        $this->setEnderecoId($enderecoId);
        $this->setNumeroEndereco($numeroEndereco);
        $this->complementoCliente = $complementoCliente;
    }

    private function setNomeCliente(string $nomeCliente): void
    {
        if (empty(trim($nomeCliente))) {
            throw new HttpException("Nome do cliente é obrigatório", 400);
        }

        $this->nomeCliente = trim($nomeCliente);
    }

    private function setCpf(string $cpf): void
    {
        $cpf = preg_replace('/\D/', '', $cpf);

        if (strlen($cpf) !== 11) {
            throw new HttpException("CPF inválido", 400);
        }

        $this->cpf = $cpf;
    }

    private function setSituacaoClienteId(int $situacaoClienteId): void
    {
        if ($situacaoClienteId <= 0) {
            throw new HttpException("Situação do cliente inválida", 400);
        }

        $this->situacaoClienteId = $situacaoClienteId;
    }

    private function setEnderecoId(int $enderecoId): void
    {
        if ($enderecoId <= 0) {
            throw new HttpException("Endereço inválido", 400);
        }

        $this->enderecoId = $enderecoId;
    }

    private function setNumeroEndereco(int $numeroEndereco): void
    {
        if ($numeroEndereco <= 0) {
            throw new HttpException("Número do endereço inválido", 400);
        }

        $this->numeroEndereco = $numeroEndereco;
    }

    public function getNomeCliente(): string { return $this->nomeCliente; }
    public function getCpf(): string { return $this->cpf; }
    public function getSituacaoClienteId(): int { return $this->situacaoClienteId; }
    public function getEnderecoId(): int { return $this->enderecoId; }
    public function getNumeroEndereco(): int { return $this->numeroEndereco; }
    public function getComplementoCliente(): ?string { return $this->complementoCliente; }
}

?>