<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\ISituacaoClientesRepository;
use Src\Database\Connection;
use PDO;

class SituacaoClientesRepository implements ISituacaoClientesRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(string $descricaoSituacao): void
    {
        $stmt = $this->conn->prepare("
            INSERT INTO situacaoclientes (descricao_situacao)
            VALUES (?)
        ");

        $stmt->execute([$descricaoSituacao]);
    }

    public function list(): array
    {
        $stmt = $this->conn->prepare("
            SELECT id, descricao_situacao, data_criacao
            FROM situacaoclientes
            ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT id, descricao_situacao, data_criacao
            FROM situacaoclientes
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        return $role ?: null;
    }

    public function update(int $id, string $descricaoSituacao): void
    {
        $stmt = $this->conn->prepare("
            UPDATE situacaoclientes
               SET descricao_situacao = ?
             WHERE id = ?
        ");

        $stmt->execute([$descricaoSituacao, $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("
            DELETE FROM situacaoclientes
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}

?>