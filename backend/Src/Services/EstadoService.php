<?php

namespace Src\Services;

use Src\Domain\Repositories\IEstadoRepository;
use Src\Domain\Entities\Estado;

class EstadoService
{
    private IEstadoRepository $repository;

    public function __construct(IEstadoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($nomeEstado, $uf)
    {
        // cria entidade
        $estado = new Estado($nomeEstado, $uf);

        $this->repository->create(
            $estado->getNome(),
            $estado->getUf()
        );
    }

    public function list(): array
    {
        return $this->repository->list();
    }

    public function update(int $id, string $nomeEstado, string $uf): void
    {
        $estado = $this->repository->findById($id);

        if (!$estado) {
            throw new \Src\Core\HttpException("Estado não encontrado", 404);
        }

        $estadoComMesmoNome = $this->repository->findByName($nomeEstado);

        if ($estadoComMesmoNome && (int)$estadoComMesmoNome['id'] !== $id) {
            throw new \Src\Core\HttpException("Já existe um estado com este nome", 400);
        }

        if (empty($nomeEstado)) {
            throw new \Src\Core\HttpException("Nome do estado é obrigatório", 400);
        }

        $this->repository->update($id, $nomeEstado, $uf);
    }

    public function delete(int $id): void
    {
        $estado = $this->repository->findById($id);

        if (!$estado) {
        throw new \Src\Core\HttpException("Estado não encontrado", 404);
        }

        $this->repository->delete($id);
    }
}

?>