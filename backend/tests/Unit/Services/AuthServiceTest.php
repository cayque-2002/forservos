<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use Src\Services\AuthService;
use Src\Core\HttpException;
use Tests\Fakes\FakeUsuarioRepository;

class AuthServiceTest extends TestCase
{
    protected function setUp(): void
    {
        $_ENV['JWT_SECRET'] = 'chave_super_secreta_para_testes_123456';
        $_ENV['JWT_EXPIRATION'] = 3600;
    }

    public function test_deve_retornar_token_quando_credenciais_forem_validas(): void
    {
        $repository = new FakeUsuarioRepository();

        $repository->create(
            'Administrador',
            'admin@teste.com',
            password_hash('Senha@123', PASSWORD_BCRYPT),
            1
        );

        $service = new AuthService($repository);

        $token = $service->login('admin@teste.com', 'Senha@123');

        $this->assertNotEmpty($token);
        $this->assertIsString($token);
    }

    public function test_deve_lancar_erro_quando_usuario_nao_existir(): void
    {
        $repository = new FakeUsuarioRepository();
        $service = new AuthService($repository);

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Usuário não encontrado');

        $service->login('inexistente@teste.com', 'Senha@123');
    }

    public function test_deve_lancar_erro_quando_senha_for_invalida(): void
    {
        $repository = new FakeUsuarioRepository();

        $repository->create(
            'Administrador',
            'admin@teste.com',
            password_hash('Senha@123', PASSWORD_BCRYPT),
            1
        );

        $service = new AuthService($repository);

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Credenciais inválidas');

        $service->login('admin@teste.com', 'SenhaErrada@123');
    }
}

?>