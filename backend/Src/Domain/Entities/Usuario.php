<?php

namespace Src\Domain\Entities;

use Src\Core\Exceptions\HttpException;

class Usuario
{
    private string $nome;
    private string $email;
    private string $senha;
    private int $roleid;

    public function __construct(
        string $nome,
        string $email,
        string $senha,
        int $roleid
    ) {
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setRole($roleid);
    }

    private function setNome(string $nome)
    {
        if (empty($nome)) {
            throw new \Src\Core\HttpException("Nome é obrigatório", 400);
        }

        $this->nome = $nome;
    }

    private function setEmail(string $email)
    {
        if (empty($email)) {
            throw new \Src\Core\HttpException("Email é obrigatório", 400);
        }

        $this->email = $email;
    }

    private function setSenha(string $senha)
    {
        if (empty($senha)) {
            throw new \Src\Core\HttpException("Senha é obrigatória", 400);
        }

        $this->senha = password_hash($senha, PASSWORD_BCRYPT);
    }

    private function setValidaEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Src\Core\HttpException("Email inválido", 400);
        }

        $this->email = $email;
    }

    private function setValidaSenha(string $senha)
    {
        if (strlen($senha) < 8) {
            throw new \Src\Core\HttpException("Senha deve ter no mínimo 6 caracteres", 400);
        }
        if (!preg_match('/[A-Z]/', $senha)){
            throw new \Src\Core\HttpException("A senha deve ter no mínimo uma letra maiúscula.",400);
        }
        if (!preg_match('/\d/', $senha)){
            throw new \Src\Core\HttpException("A senha deve ter no mínimo um número.",400);
        }
        if (!preg_match('/[\W_]/', $senha)){
            throw new \Src\Core\HttpException("A senha deve ter no mínimo um caractere especial.",400);
        }

        $this->senha = password_hash($senha, PASSWORD_BCRYPT);
    }

    private function setRole(int $roleid)
    {
        if ($roleid <= 0) {
            throw new \Src\Core\HttpException("Role inválida", 400);
        }

        $this->roleid = $roleid;
    }

    //get (somente leitura)
    public function getNome(): string { return $this->nome; }
    public function getEmail(): string { return $this->email; }
    public function getSenha(): string { return $this->senha; }
    public function getRoleId(): int { return $this->roleid; }
}

?>