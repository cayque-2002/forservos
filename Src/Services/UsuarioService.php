<?php
namespace Src\Services;

use Src\Infrastructure\Repositories\UsuarioRepository;
use Src\Domain\Repositories\IUsuarioRepository;


class UsuarioService
{
    private IUsuarioRepository $repository;

    public function __construct(IUsuarioRepository $repository)
    {
        $this->repository = $repository;
    }

  public function create(string $nome, string $email, string $senha, int $roleid)
    {
        if (!$nome || !$email || !$senha) {
            throw new \Exception("Dados inválidos");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Email inválido");
        }

        $this->validarSenha($senha);

        $existing = $this->repo->findByEmail($email);

        if ($existing) {
            throw new \Exception("Usuário já existe");
        }

        $this->repository->create($nome, $email, $senha, $roleid);
    }


    private function validarSenha(string $senha): void
    {

        if (strlen($senha) < 8){
            throw new \Exception(
                "A senha deve ter no mínimo 8 caracteres."
            );
        }
        if (!preg_match('/[A-Z]/', $senha)){
            throw new \Exception(
                "A senha deve ter no mínimo uma letra maiúscula."
            );
        }
        if (!preg_match('/\d/', $senha)){
            throw new \Exception(
                "A senha deve ter no mínimo um número."
            );
        }
        if (!preg_match('/[\W_]/', $senha)){
            throw new \Exception(
                "A senha deve ter no mínimo um caractere especial."
            );
        }

        // if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $senha)) {
        //     throw new \Exception(
        //         "A senha deve ter no mínimo 8 caracteres sendo mínimo: uma letra maiúscula, 
        //          um número e um caractere especial"
        //     );
        // }
    }

}
?>