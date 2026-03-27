<?php

namespace Src\Services;

use Src\Domain\Entities\Endereco;
use Src\Domain\Repositories\IEnderecoRepository;
use Src\Core\HttpException;

class EnderecoService
{
    public function __construct(private IEnderecoRepository $repository) {}

    public function create(string $logradouro, string $bairro, string $cep, int $cidadeId, ?string $complementoEndereco): int
    {
        $endereco = new Endereco($logradouro, $bairro, $cep, $cidadeId, $complementoEndereco);

        return $this->repository->create(
            $endereco->getLogradouro(),
            $endereco->getBairro(),
            $endereco->getCep(),
            $endereco->getCidadeId(),
            $endereco->getComplementoEndereco()
        );
    }

    public function list(): array
    {
        return $this->repository->list();
    }

    public function update(int $id, string $logradouro, string $bairro, string $cep, int $cidadeId, ?string $complementoEndereco): void
    {
        if (!$this->repository->findById($id)) {
            throw new HttpException("Endereço não encontrado", 404);
        }

        $endereco = new Endereco($logradouro, $bairro, $cep, $cidadeId, $complementoEndereco);

        $this->repository->update(
            $id,
            $endereco->getLogradouro(),
            $endereco->getBairro(),
            $endereco->getCep(),
            $endereco->getCidadeId(),
            $endereco->getComplementoEndereco()
        );
    }

    public function delete(int $id): void
    {
        if (!$this->repository->findById($id)) {
            throw new HttpException("Endereço não encontrado", 404);
        }

        $this->repository->delete($id);
    }
}

?>