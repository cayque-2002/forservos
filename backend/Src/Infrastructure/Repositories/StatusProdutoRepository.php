<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\IStatusProdutoRepository;
use Src\Database\Connection;
use PDO;

class StatusProdutoRepository implements IStatusProdutoRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(string $descricaoStatus): void
    {
        $stmt = $this->conn->prepare("
            INSERT INTO statusproduto (descricao_status)
            VALUES (?)
        ");

        $stmt->execute([$descricaoStatus]);
    }

    public function list(): array
    {
        $stmt = $this->conn->prepare("
            SELECT id, descricao_status, data_criacao
            FROM statusproduto
            ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT id, descricao_status, data_criacao
            FROM statusproduto
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        return $role ?: null;
    }

    public function update(int $id, string $descricaoStatus): void
    {
        $stmt = $this->conn->prepare("
            UPDATE statusproduto
               SET descricao_status = ?
             WHERE id = ?
        ");

        $stmt->execute([$descricaoStatus, $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("
            DELETE FROM statusproduto
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}

?>