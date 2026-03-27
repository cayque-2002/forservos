<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\IProdutoRepository;
use Src\Database\Connection;
use PDO;

class ProdutoRepository implements IProdutoRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(int $codProduto, string $descricaoProduto, float $valorProduto, int $statusId, int $tipoPrazoGarantiaId, int $tempoGarantia): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO produtos (
                codproduto, descricao_produto, valor_produto, statusid, tipoprazogarantiaid, tempo_garantia
            ) VALUES (?, ?, ?, ?, ?, ?)
            RETURNING id
        ");

        $stmt->execute([
            $codProduto,
            $descricaoProduto,
            $valorProduto,
            $statusId,
            $tipoPrazoGarantiaId,
            $tempoGarantia
        ]);

        return (int)$stmt->fetchColumn();
    }

    public function list(): array
    {
        $stmt = $this->conn->prepare("
            SELECT p.*, sp.descricao_status, tpg.descricao_prazo
            FROM produtos p
            JOIN statusproduto sp ON sp.id = p.statusid
            JOIN tipoprazogarantia tpg ON tpg.id = p.tipoprazogarantiaid
            ORDER BY p.id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);

        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        return $produto ?: null;
    }

    public function update(int $id, int $codProduto, string $descricaoProduto, float $valorProduto, int $statusId, int $tipoPrazoGarantiaId, int $tempoGarantia): void
    {
        $stmt = $this->conn->prepare("
            UPDATE produtos
               SET codproduto = ?,
                   descricao_produto = ?,
                   valor_produto = ?,
                   statusid = ?,
                   tipoprazogarantiaid = ?,
                   tempo_garantia = ?
             WHERE id = ?
        ");

        $stmt->execute([
            $codProduto,
            $descricaoProduto,
            $valorProduto,
            $statusId,
            $tipoPrazoGarantiaId,
            $tempoGarantia,
            $id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
    }
}

?>