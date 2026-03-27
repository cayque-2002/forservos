<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\ITipoPrazoGarantiaRepository;
use Src\Database\Connection;
use PDO;

class TipoPrazoGarantiaRepository implements ITipoPrazoGarantiaRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(string $descricaoPrazo): void
    {
        $stmt = $this->conn->prepare("
            INSERT INTO tipoprazogarantia (descricao_prazo)
            VALUES (?)
        ");

        $stmt->execute([$descricaoPrazo]);
    }

    public function list(): array
    {
        $stmt = $this->conn->prepare("
            SELECT id, descricao_prazo, data_criacao
            FROM tipoprazogarantia
            ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT id, descricao_prazo, data_criacao
            FROM tipoprazogarantia
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        return $role ?: null;
    }

    public function update(int $id, string $descricaoPrazo): void
    {
        $stmt = $this->conn->prepare("
            UPDATE tipoprazogarantia
               SET descricao_prazo = ?
             WHERE id = ?
        ");

        $stmt->execute([$descricaoPrazo, $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("
            DELETE FROM tipoprazogarantia
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}

?>