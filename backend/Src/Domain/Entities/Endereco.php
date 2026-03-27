<?php

namespace Src\Domain\Entities;

use Src\Core\HttpException;

class Endereco
{
    private string $logradouro;
    private string $bairro;
    private string $cep;
    private int $cidadeId;
    private ?string $complementoEndereco;

    public function __construct(
        string $logradouro,
        string $bairro,
        string $cep,
        int $cidadeId,
        ?string $complementoEndereco = null
    ) {
        $this->setLogradouro($logradouro);
        $this->setBairro($bairro);
        $this->setCep($cep);
        $this->setCidadeId($cidadeId);
        $this->complementoEndereco = $complementoEndereco;
    }

    private function setLogradouro(string $logradouro): void
    {
        if (empty(trim($logradouro))) {
            throw new HttpException("Logradouro é obrigatório", 400);
        }

        $this->logradouro = trim($logradouro);
    }

    private function setBairro(string $bairro): void
    {
        if (empty(trim($bairro))) {
            throw new HttpException("Bairro é obrigatório", 400);
        }

        $this->bairro = trim($bairro);
    }

    private function setCep(string $cep): void
    {
        $cep = preg_replace('/\D/', '', $cep);

        if (strlen($cep) !== 8) {
            throw new HttpException("CEP inválido", 400);
        }

        $this->cep = $cep;
    }

    private function setCidadeId(int $cidadeId): void
    {
        if ($cidadeId <= 0) {
            throw new HttpException("Cidade inválida", 400);
        }

        $this->cidadeId = $cidadeId;
    }

    public function getLogradouro(): string { return $this->logradouro; }
    public function getBairro(): string { return $this->bairro; }
    public function getCep(): string { return $this->cep; }
    public function getCidadeId(): int { return $this->cidadeId; }
    public function getComplementoEndereco(): ?string { return $this->complementoEndereco; }
}

?>