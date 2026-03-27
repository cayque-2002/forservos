<?php

namespace Src\Domain\Entities;

use Src\Core\Exceptions\HttpException;

class StatusProduto
{
    private string $descricaoStatus;
    
    public function __construct(
        string $descricaoStatus
        
    ) {
        $this->setDescricaoStatus($descricaoStatus);
    }

    private function setDescricaoStatus(string $descricaoStatus)
    {
        if (empty($descricaoStatus)) {
            throw new \Src\Core\HttpException("Descrição é obrigatória", 400);
        }

        $this->descricaoStatus = $descricaoStatus;
    }

    //get (somente leitura)
    public function getDescricaoStatus(): string { return $this->descricaoStatus; }

}

?>