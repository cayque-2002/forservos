<?php

namespace Src\Domain\Entities;

use Src\Core\Exceptions\HttpException;

class TipoPrazoGarantia
{
    private string $descricaoPrazo;
    
    public function __construct(
        string $descricaoPrazo
        
    ) {
        $this->setDescricaoPrazo($descricaoPrazo);
    }

    private function setDescricaoPrazo(string $descricaoPrazo)
    {
        if (empty($descricaoPrazo)) {
            throw new \Src\Core\HttpException("Descrição é obrigatória", 400);
        }

        $this->descricaoPrazo = $descricaoPrazo;
    }

    //get (somente leitura)
    public function getDescricaoPrazo(): string { return $this->descricaoPrazo; }

}

?>