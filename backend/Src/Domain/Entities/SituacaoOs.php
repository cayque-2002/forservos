<?php

namespace Src\Domain\Entities;

use Src\Core\Exceptions\HttpException;

class SituacaoOS
{
    private string $descricaoSituacaoOs;
    
    public function __construct(
        string $descricaoSituacaoOs
        
    ) {
        $this->setDescricaoSituacaoOs($descricaoSituacaoOs);
    }

    private function setDescricaoSituacaoOs(string $descricaoSituacaoOs)
    {
        if (empty($descricaoSituacaoOs)) {
            throw new \Src\Core\HttpException("Descrição é obrigatória", 400);
        }

        $this->descricaoSituacaoOs = $descricaoSituacaoOs;
    }

    //get (somente leitura)
    public function getDescricaoSituacaoOs(): string { return $this->descricaoSituacaoOs; }

}

?>