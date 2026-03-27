<?php

namespace Src\Domain\Entities;

use Src\Core\Exceptions\HttpException;

class Estado
{
    private string $nomeEstado;
    private string $uf;
    
    public function __construct(
        string $nomeEstado,
        string $uf
    ) {
        $this->setNome($nomeEstado);
        $this->setEmail($uf);
    }

    private function setNome(string $nomeEstado)
    {
        if (empty($nomeEstado)) {
            throw new \Src\Core\HttpException("Nome do estado é obrigatório", 400);
        }

        $this->nomeEstado = $nomeEstado;
    }

    private function setEmail(string $uf)
    {
        if (empty($uf)) {
            throw new \Src\Core\HttpException("Sigla UF é obrigatória", 400);
        }

        $this->uf = $uf;
    }

    private function setValidaUf(string $uf)
    {
        if (strlen($uf) != 2) {
            throw new \Src\Core\HttpException("Sigla UF deve ter somente 2 caracteres", 400);
        }

        $this->uf = $uf;
    }

    //get (somente leitura)
    public function getNome(): string { return $this->nomeEstado; }
    public function getUf(): string { return $this->uf; }
    
}

?>