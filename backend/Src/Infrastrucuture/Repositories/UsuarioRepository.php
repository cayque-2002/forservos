<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\IUsuarioRepository;
use PDO;

class UsuarioRepository implements IUsuarioRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function create(string $nome, string $email, string $senha, int $roleId): void
    {
        $stmt = $this->conn->prepare("
            INSERT INTO usuarios (nome, email, senha, role_id)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([$nome, $email, $senha, $roleId]);
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT * FROM usuarios WHERE email = ?
        ");

        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }
}

?>