<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\ICidadeRepository;
use Src\Database\Connection;
use PDO;

class CidadeRepository implements ICidadeRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(string $nomeCidade, int $estadoId): void
    {
        $stmt = $this->conn->prepare("
            INSERT INTO cidade (nome_cidade,estadoId)
            VALUES (?, ?)
        ");

        $stmt->execute([$nomeCidade,$estadoId]);
    }

    public function findByName(string $nomeCidade): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT c.*, e.nome_estado, e.uf
            FROM cidade c
            JOIN estado e ON e.id = c.estadoid
            WHERE c.nome_cidade ILIKE ?
        ");

        $stmt->execute(["%{$nomeCidade}%"]);

        $cidade = $stmt->fetch(PDO::FETCH_ASSOC);

        return $cidade ?: null;
    }

     public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT 
                c.id,
                c.nome_cidade,
                c.estadoid,
                e.nome_estado,
                e.uf
            FROM cidade c
            JOIN estado e ON e.id = c.estadoid
            WHERE c.id = ?
        ");

        $stmt->execute([$id]);

        $cidade = $stmt->fetch(PDO::FETCH_ASSOC);

        return $cidade ?: null;
    }

    public function list(): array
    {
        $stmt = $this->conn->prepare("
            SELECT 
                c.id,
                c.nome_cidade,
                c.estadoid,
                e.nome_estado,
                e.uf
            FROM cidade c
            JOIN estado e ON e.id = c.estadoid
            ORDER BY c.id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(int $id, string $nomeCidade, int $estadoId): void
    {
        $stmt = $this->conn->prepare("
            UPDATE cidade
               SET nome_cidade = ?,
                   estadoId = ?
             WHERE id = ?
        ");

        $stmt->execute([$nomeCidade, $estadoId, $id]);
    }

    public function delete(int $id): void
    {   
        $stmt = $this->conn->prepare("
            DELETE FROM cidade
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}

?>