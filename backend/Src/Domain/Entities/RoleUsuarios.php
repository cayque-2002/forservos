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
        if (empty($nome_role)) {
            throw new \Src\Core\HttpException("Nome da role é obrigatória", 400);
        }

        $this->nome_role = $nome_role;
    }

    //get (somente leitura)
    public function getNome(): string { return $this->nome; }

}

?>