<?php

namespace Src\Domain\Entities;

use Src\Core\Exceptions\HttpException;

class SituacaoClientes
{
    private string $descricaoSituacao;
    
    public function __construct(
        string $descricaoSituacao
        
    ) {
        $this->setDescricaoSituacao($descricaoSituacao);
    }

    private function setDescricaoSituacao(string $descricaoSituacao)
    {
        if (empty($descricaoSituacao)) {
            throw new \Src\Core\HttpException("Descrição é obrigatória", 400);
        }

        $this->descricaoSituacao = $descricaoSituacao;
    }

    //get (somente leitura)
    public function getDescricaoSituacao(): string { return $this->descricaoSituacao; }

}

?>