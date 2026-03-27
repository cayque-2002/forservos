<?php

namespace Src\Services;

use Src\Domain\Repositories\IUsuarioRepository;
use Src\Domain\Entities\Usuario;

class UsuarioService
{
    private IUsuarioRepository $repository;

    public function __construct(IUsuarioRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($nome, $email, $senha, $roleId)
    {
        // cria entidade (validações principais na propria entidade)
        $usuario = new Usuario($nome, $email, $senha, $roleId);

        $this->repository->create(
            $usuario->getNome(),
            $usuario->getEmail(),
            $usuario->getSenha(),
            $usuario->getRoleId()
        );
    }

    public function list(): array
    {
        return $this->repository->list();
    }

    public function update(int $id, string $nome, string $email, int $roleid, bool $ativo): void
    {
        $usuario = $this->repository->findById($id);

        if (!$usuario) {
            throw new \Src\Core\HttpException("Usuário não encontrado", 404);
        }

        $usuarioComMesmoEmail = $this->repository->findByEmail($email);

        if ($usuarioComMesmoEmail && (int)$usuarioComMesmoEmail['id'] !== $id) {
            throw new \Src\Core\HttpException("Já existe um usuário com este email", 400);
        }

        if (empty($nome)) {
            throw new \Src\Core\HttpException("Nome é obrigatório", 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Src\Core\HttpException("Email inválido", 400);
        }

        if ($roleid <= 0) {
            throw new \Src\Core\HttpException("Perfil inválido", 400);
        }

        $this->repository->update($id, $nome, $email, $roleid, $ativo);
    }

    public function delete(int $id): void
    {
        $usuario = $this->repository->findById($id);

        if (!$usuario) {
        throw new \Src\Core\HttpException("Usuário não encontrado", 404);
        }

        $this->repository->delete($id);
    }
}

?>