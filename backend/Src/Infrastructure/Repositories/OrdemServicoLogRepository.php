<?php

namespace Src\Infrastructure\Repositories;

use Src\Domain\Repositories\IOrdemServicoLogRepository;
use Src\Database\Connection;
use PDO;

class OrdemServicoLogRepository implements IOrdemServicoLogRepository
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
    }

    public function create(int $ordemServicoId, string $acao, array $dados): void
    {
        $stmt = $this->conn->prepare("
            INSERT INTO ordemservico_logs (ordemservicoid, acao, dados)
            VALUES (?, ?, ?::jsonb)
        ");

        $stmt->execute([
            $ordemServicoId,
            $acao,
            json_encode($dados, JSON_UNESCAPED_UNICODE)
        ]);
    }

    public function listByOrdemServicoId(int $ordemServicoId): array
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM ordemservico_logs
            WHERE ordemservicoid = ?
            ORDER BY id DESC
        ");

        $stmt->execute([$ordemServicoId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>