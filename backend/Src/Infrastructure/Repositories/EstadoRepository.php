<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\IEstadoRepository;
use Src\Database\Connection;
use PDO;

class EstadoRepository implements IEstadoRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(string $nomeEstado, string $uf): void
    {
        $stmt = $this->conn->prepare("
            INSERT INTO estado (nome_estado,uf)
            VALUES (?, ?)
        ");

        $stmt->execute([$nomeEstado, $uf]);
    }

    public function findByName(string $nomeEstado): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT e.*
            FROM estado e
            WHERE e.nome_estado ILIKE ?
        ");

        $stmt->execute(["%{$nomeEstado}%"]);

        $estado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $estado ?: null;
    }

     public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("
            SELECT 
                e.id,
                e.nome_estado,
                e.data_criacao
            FROM estado e
            WHERE e.id = ?
        ");

        $stmt->execute([$id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function list(): array
    {
        $stmt = $this->conn->prepare("
            SELECT 
                e.id,
                e.nome_estado,
                e.data_criacao
            FROM estado e
            ORDER BY e.id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(int $id, string $nomeEstado, string $uf): void
    {
        $stmt = $this->conn->prepare("
            UPDATE estado
               SET nome_estado = ?,
                   uf = ?
             WHERE id = ?
        ");

        $stmt->execute([$nomeEstado, $uf, $id]);
    }

    public function delete(int $id): void
    {   
        $stmt = $this->conn->prepare("
            DELETE FROM estado
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}

?>