<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\IOrdemServicoRepository;
use Src\Database\Connection;
use PDO;

class OrdemServicoRepository implements IOrdemServicoRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(int $numOs, int $situacaoOsId, int $clienteId, int $produtoId, int $cidadeId, ?string $observacao): int
    {
        $stmt = $this->conn->prepare("
            INSERT INTO ordemservico (
                numos, situacaoosid, clienteid, produtoid, cidadeid, observacao
            ) VALUES (?, ?, ?, ?, ?, ?)
            RETURNING id
        ");

        $stmt->execute([
            $numOs,
            $situacaoOsId,
            $clienteId,
            $produtoId,
            $cidadeId,
            $observacao
        ]);

        return (int)$stmt->fetchColumn();
    }

    public function list(): array
    {
        $stmt = $this->conn->prepare("
            SELECT 
                os.*,
                c.nome_cliente,
                c.cpf,
                p.descricao_produto,
                s.descricao_situacao_os,
                ci.nome_cidade
            FROM ordemservico os
            JOIN clientes c ON c.id = os.clienteid
            JOIN produtos p ON p.id = os.produtoid
            JOIN situacaoos s ON s.id = os.situacaoosid
            JOIN cidade ci ON ci.id = os.cidadeid
            ORDER BY os.id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listDashboardHoje(): array
    {
        $stmt = $this->conn->prepare("
            SELECT 
                os.*,
                c.nome_cliente,
                c.cpf,
                p.descricao_produto,
                s.descricao_situacao_os
            FROM ordemservico os
            JOIN clientes c ON c.id = os.clienteid
            JOIN produtos p ON p.id = os.produtoid
            JOIN situacaoos s ON s.id = os.situacaoosid
            WHERE DATE(os.data_criacao) = CURRENT_DATE
              AND LOWER(s.descricao_situacao_os) IN ('pendente', 'em atendimento')
            ORDER BY os.id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM ordemservico WHERE id = ?");
        $stmt->execute([$id]);

        $os = $stmt->fetch(PDO::FETCH_ASSOC);
        return $os ?: null;
    }

    public function findByNumOs(int $numOs): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM ordemservico WHERE numos = ?");
        $stmt->execute([$numOs]);

        $os = $stmt->fetch(PDO::FETCH_ASSOC);
        return $os ?: null;
    }

    public function update(int $id, int $numOs, int $situacaoOsId, int $clienteId, int $produtoId, int $cidadeId, ?string $observacao): void
    {
        $stmt = $this->conn->prepare("
            UPDATE ordemservico
               SET numos = ?,
                   situacaoosid = ?,
                   clienteid = ?,
                   produtoid = ?,
                   cidadeid = ?,
                   observacao = ?
             WHERE id = ?
        ");

        $stmt->execute([
            $numOs,
            $situacaoOsId,
            $clienteId,
            $produtoId,
            $cidadeId,
            $observacao,
            $id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->conn->prepare("DELETE FROM ordemservico WHERE id = ?");
        $stmt->execute([$id]);
    }
}

?>