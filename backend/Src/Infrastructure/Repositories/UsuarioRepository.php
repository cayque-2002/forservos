<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\IUsuarioRepository;
use Src\Database\Connection;
use PDO;

class UsuarioRepository implements IUsuarioRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(string $nome, string $email, string $senha, int $roleId): void
    {
        $stmt = $this->conn->prepare("
            INSERT INTO usuarios (nome, email, senha, roleid)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([$nome, $email, $senha, $roleId]);
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT u.*, r.nome_role
            FROM usuarios u
            JOIN role_usuarios r ON r.id = u.roleid
            WHERE u.email ILIKE ?
        ");

        $stmt->execute(["%{$email}%"]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

     public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT 
                u.id,
                u.nome,
                u.email,
                u.roleid,
                u.ativo,
                r.nome_role
            FROM usuarios u
            JOIN role_usuarios r ON r.id = u.roleid
            WHERE u.id = ?
        ");

        $stmt->execute([$id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function list(): array
    {
        $stmt = $this->conn->prepare("
            SELECT 
                u.id,
                u.nome,
                u.email,
                u.roleid,
                u.ativo,
                u.data_criacao,
                r.nome_role
            FROM usuarios u
            JOIN role_usuarios r ON r.id = u.roleid
            ORDER BY u.id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(int $id, string $nome, string $email, int $roleId, bool $ativo): void
    {
        $stmt = $this->conn->prepare("
            UPDATE usuarios
               SET nome = ?,
                   email = ?,
                   roleid = ?,
                   ativo = ?
             WHERE id = ?
        ");

        $stmt->execute([$nome, $email, $roleId, $ativo, $id]);
    }

    public function delete(int $id): void
    {   
        $stmt = $this->conn->prepare("
            DELETE FROM usuarios
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}

?>