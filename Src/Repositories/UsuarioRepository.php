<?php

namespace Src\Repositories;

use Src\Database\Connection;
use PDO;

class UsuarioRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->conn->prepare("SELECT u.*, r.nome_role
                                      FROM usuarios u
                                      JOIN role_usuarios r on r.id = u.roleid
                                      WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(string $nome, string $email, string $senha, int $roleid)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO usuarios (nome, email, senha, roleid)
            VALUES (:nome, :email, :senha, :roleid)
        ");

        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => password_hash($senha, PASSWORD_BCRYPT),
            ':roleid' => $roleid
        ]);
    }
}