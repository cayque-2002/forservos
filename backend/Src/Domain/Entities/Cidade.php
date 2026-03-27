<?php

namespace Src\Domain\Entities;

use Src\Core\Exceptions\HttpException;

class Cidade
{
    private string $nomeCidade;
    private int $estadoId;

    public function __construct(
        string $nomeCidade,
        int $estadoId
    ) {
        $this->setNomeCidade($nomeCidade);
        $this->setEstado($estadoId);
    }

    private function setNomeCidade(string $nomeCidade)
    {
        if (empty($nomeCidade)) {
            throw new \Src\Core\HttpException("Nome da cidade é obrigatório", 400);
        }

        $this->nomeCidade = $nomeCidade;
    }

    private function setEstado(int $estadoId)
    {
        if ($estadoId <= 0) {
            throw new \Src\Core\HttpException("Estado inválido", 400);
        }

        $this->estadoId = $estadoId;
    }

    //get (somente leitura)
    public function getNomeCidade(): string { return $this->nomeCidade; }
    public function getEstadoId(): int { return $this->estadoId; }
}

?>