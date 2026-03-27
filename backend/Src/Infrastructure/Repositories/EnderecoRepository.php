<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\IEnderecoRepository;
use Src\Database\Connection;
use PDO;

class EnderecoRepository implements IEnderecoRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(string $logradouro, string $bairro, string $cep, int $cidadeId, ?string $complementoEndereco): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO enderecos (
                logradouro, bairro, cep, cidadeid, complemento_endereco
            ) VALUES (?, ?, ?, ?, ?)
            RETURNING id
        ");

        $stmt->execute([
            $logradouro,
            $bairro,
            $cep,
            $cidadeId,
            $complementoEndereco
        ]);

        return (int)$stmt->fetchColumn();
    }

    public function list(): array
    {
        $stmt = $this->conn->prepare("
            SELECT e.*, c.nome_cidade, es.nome_estado, es.uf
            FROM enderecos e
            JOIN cidade c ON c.id = e.cidadeid
            JOIN estado es ON es.id = c.estadoid
            ORDER BY e.id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM enderecos WHERE id = ?");
        $stmt->execute([$id]);

        $endereco = $stmt->fetch(PDO::FETCH_ASSOC);
        return $endereco ?: null;
    }

    public function update(int $id, string $logradouro, string $bairro, string $cep, int $cidadeId, ?string $complementoEndereco): void
    {
        $stmt = $this->conn->prepare("
            UPDATE enderecos
               SET logradouro = ?,
                   bairro = ?,
                   cep = ?,
                   cidadeid = ?,
                   complemento_endereco = ?
             WHERE id = ?
        ");

        $stmt->execute([
            $logradouro,
            $bairro,
            $cep,
            $cidadeId,
            $complementoEndereco,
            $id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("DELETE FROM enderecos WHERE id = ?");
        $stmt->execute([$id]);
    }
}

?>