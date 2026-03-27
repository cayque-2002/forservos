<?php

namespace Src\Domain\Entities;

use Src\Core\Exceptions\HttpException;

class RoleUsuarios
{
    private string $nome_role;
    
    public function __construct(
        string $nome_role
        
    ) {
        $this->setNome($nome_role);
    }

    private function setNome(string $nome_role)
    {
        if (empty($nome)) {
            throw new \Src\Core\HttpException("Nome é obrigatório", 400);
        }

        $this->nome = $nome;
    }

    //get (somente leitura)
    public function getNome(): string { return $this->nome; }

}

?>