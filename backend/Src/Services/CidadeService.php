<?php

namespace Src\Services;

use Src\Domain\Repositories\ICidadeRepository;
use Src\Domain\Entities\Cidade;

class CidadeService
{
    private ICidadeRepository $repository;

    public function __construct(ICidadeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($nomeCidade, $estadoId)
    {
        // cria entidade
        $cidade = new Cidade($nomeCidade,$estadoId);

        $this->repository->create(
            $cidade->getNomeCidade(),
            $cidade->getEstadoId()
        );
    }

    public function list(): array
    {
        return $this->repository->list();
    }

    public function update(int $id, string $nomeCidade, int $estadoId): void
    {
        $cidade = $this->repository->findById($id);

        if (!$cidade) {
            throw new \Src\Core\HttpException("Cidade não encontrada", 404);
        }

        $cidadeComMesmoNome = $this->repository->findByName($nomeCidade);

        if ($cidadeComMesmoNome && (int)$cidadeComMesmoNome['id'] !== $id) {
            throw new \Src\Core\HttpException("Já existe uma cidade com este nome", 400);
        }

        if (empty($nomeCidade)) {
            throw new \Src\Core\HttpException("Nome da cidade é obrigatório", 400);
        }

        if ($estadoId <= 0) {
            throw new \Src\Core\HttpException("Estado inválido", 400);
        }

        $this->repository->update($id, $nomeCidade, $estadoId);
    }

    public function delete(int $id): void
    {
        $cidade = $this->repository->findById($id);

        if (!$cidade) {
        throw new \Src\Core\HttpException("Cidade não encontrada", 404);
        }

        $this->repository->delete($id);
    }
}

?>