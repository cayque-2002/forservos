<?php

namespace Tests\Fakes;

use Src\Domain\Repositories\IUsuarioRepository;

class FakeUsuarioRepository implements IUsuarioRepository
{
    public array $usuarios = [];
    private int $autoIncrement = 1;

    public function create(string $nome, string $email, string $senha, int $roleId): void
    {
        $this->usuarios[] = [
            'id' => $this->autoIncrement++,
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha,
            'roleid' => $roleId,
            'ativo' => true,
            'nome_role' => $roleId === 1 ? 'admin' : 'user'
        ];
    }

    public function findByEmail(string $email): ?array
    {
        foreach ($this->usuarios as $usuario) {
            if ($usuario['email'] === $email) {
                return $usuario;
            }
        }

        return null;
    }

    public function findById(int $id): ?array
    {
        foreach ($this->usuarios as $usuario) {
            if ($usuario['id'] === $id) {
                return $usuario;
            }
        }

        return null;
    }

    public function list(): array
    {
        return $this->usuarios;
    }

    public function update(int $id, string $nome, string $email, int $roleId, bool $ativo): void
    {
        foreach ($this->usuarios as &$usuario) {
            if ($usuario['id'] === $id) {
                $usuario['nome'] = $nome;
                $usuario['email'] = $email;
                $usuario['roleid'] = $roleId;
                $usuario['ativo'] = $ativo;
                $usuario['nome_role'] = $roleId === 1 ? 'admin' : 'user';
                return;
            }
        }
    }

    public function delete(int $id): void
    {
        $this->usuarios = array_values(array_filter(
            $this->usuarios,
            fn($usuario) => $usuario['id'] !== $id
        ));
    }
}

?>