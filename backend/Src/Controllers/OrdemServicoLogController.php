<?php

namespace Src\Controllers;

use Src\Core\HttpException;
use Src\Core\Response;
use Src\Services\OrdemServicoLogService;

class OrdemServicoLogController
{
    public function __construct(private OrdemServicoLogService $service) {}

    public function listByOrdemServico()
    {
        $ordemServicoId = (int)($_GET['ordemServicoId'] ?? 0);

        if ($ordemServicoId <= 0) {
            throw new HttpException("Id da ordem de serviço não informado", 400);
        }

        Response::success(
            $this->service->listByOrdemServicoId($ordemServicoId)
        );
    }
}

?>