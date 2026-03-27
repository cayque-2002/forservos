<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\IRoleUsuariosRepository;
use Src\Database\Connection;
use PDO;

class RoleUsuariosRepository implements IRoleUsuariosRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(string $nomeRole): void
    {
        $stmt = $this->conn->prepare("
            INSERT INTO role_usuarios (nome_role)
            VALUES (?)
        ");

        $stmt->execute([$nomeRole]);
    }

    public function list(): array
    {
        $stmt = $this->conn->prepare("
            SELECT id, nome_role, data_criacao
            FROM role_usuarios
            ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT id, nome_role, data_criacao
            FROM role_usuarios
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        return $role ?: null;
    }

    public function update(int $id, string $nomeRole): void
    {
        $stmt = $this->conn->prepare("
            UPDATE role_usuarios
               SET nome_role = ?
             WHERE id = ?
        ");

        $stmt->execute([$nomeRole, $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("
            DELETE FROM role_usuarios
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}

?>