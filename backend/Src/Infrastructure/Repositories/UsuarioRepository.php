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
            WHERE u.email = ?
        ");

        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }
}

?>