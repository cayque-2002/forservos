<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\ISituacaoOsRepository;
use Src\Database\Connection;
use PDO;

class SituacaoOsRepository implements ISituacaoOsRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(string $descricaoSituacaoOs): void
    {
        $stmt = $this->conn->prepare("
            INSERT INTO situacaoos (descricao_situacao_os)
            VALUES (?)
        ");

        $stmt->execute([$descricaoSituacaoOs]);
    }

    public function list(): array
    {
        $stmt = $this->conn->prepare("
            SELECT id, descricao_situacao_os, data_criacao
            FROM situacaoos
            ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT id, descricao_situacao_os, data_criacao
            FROM situacaoos
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        return $role ?: null;
    }

    public function update(int $id, string $descricaoSituacaoOs): void
    {
        $stmt = $this->conn->prepare("
            UPDATE situacaoos
               SET descricao_situacao_os = ?
             WHERE id = ?
        ");

        $stmt->execute([$descricaoSituacaoOs, $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("
            DELETE FROM situacaoos
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}

?>