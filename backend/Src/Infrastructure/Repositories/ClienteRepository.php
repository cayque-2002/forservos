<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\IClienteRepository;
use Src\Database\Connection;
use PDO;

class ClienteRepository implements IClienteRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(string $nomeCliente, string $cpf, int $situacaoClienteId, int $enderecoId, int $numeroEndereco, ?string $complementoCliente): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO clientes (
                nome_cliente, cpf, situacaoclienteid, enderecoid, numero_endereco, complemento_cliente
            ) VALUES (?, ?, ?, ?, ?, ?)
            RETURNING id
        ");

        $stmt->execute([
            $nomeCliente,
            $cpf,
            $situacaoClienteId,
            $enderecoId,
            $numeroEndereco,
            $complementoCliente
        ]);

        return (int)$stmt->fetchColumn();
    }

    public function list(): array
    {
        $stmt = $this->conn->prepare("
            SELECT c.*, sc.descricao_situacao, e.logradouro, e.bairro, e.cep
            FROM clientes c
            JOIN situacaoclientes sc ON sc.id = c.situacaoclienteid
            JOIN enderecos e ON e.id = c.enderecoid
            ORDER BY c.id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);

        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        return $cliente ?: null;
    }

    public function findByCpf(string $cpf): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM clientes WHERE cpf = ?");
        $stmt->execute([$cpf]);

        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        return $cliente ?: null;
    }

    public function update(int $id, string $nomeCliente, string $cpf, int $situacaoClienteId, int $enderecoId, int $numeroEndereco, ?string $complementoCliente): void
    {
        $stmt = $this->conn->prepare("
            UPDATE clientes
               SET nome_cliente = ?,
                   cpf = ?,
                   situacaoclienteid = ?,
                   enderecoid = ?,
                   numero_endereco = ?,
                   complemento_cliente = ?
             WHERE id = ?
        ");

        $stmt->execute([
            $nomeCliente,
            $cpf,
            $situacaoClienteId,
            $enderecoId,
            $numeroEndereco,
            $complementoCliente,
            $id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("DELETE FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
    }
}

?>