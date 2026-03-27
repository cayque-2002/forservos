<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use Src\Services\ClienteService;
use Src\Core\HttpException;
use Tests\Fakes\FakeClienteRepository;

class ClienteServiceTest extends TestCase
{
    public function test_deve_criar_cliente_com_sucesso(): void
    {
        $repository = new FakeClienteRepository();
        $service = new ClienteService($repository);

        $id = $service->create(
            'João da Silva',
            '12345678900',
            1,
            1,
            100,
            'Casa'
        );

        $this->assertEquals(1, $id);
        $this->assertCount(1, $repository->clientes);
        $this->assertEquals('João da Silva', $repository->clientes[0]['nome_cliente']);
    }

    public function test_nao_deve_criar_cliente_com_cpf_duplicado(): void
    {
        $repository = new FakeClienteRepository();

        // cliente já existente
        $repository->create(
            'João da Silva',
            '12345678900',
            1,
            1,
            100,
            null
        );

        $service = new ClienteService($repository);

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Já existe cliente com este CPF');

        $service->create(
            'Outro Cliente',
            '12345678900',
            1,
            1,
            100,
            null
        );
    }

    public function test_deve_atualizar_cliente_com_sucesso(): void
    {
        $repository = new FakeClienteRepository();

        $id = $repository->create(
            'João',
            '12345678900',
            1,
            1,
            100,
            null
        );

        $service = new ClienteService($repository);

        $service->update(
            $id,
            'João Atualizado',
            '12345678900',
            1,
            1,
            200,
            'Apto'
        );

        $cliente = $repository->findById($id);

        $this->assertEquals('João Atualizado', $cliente['nome_cliente']);
        $this->assertEquals(200, $cliente['numero_endereco']);
    }

    public function test_nao_deve_atualizar_cliente_inexistente(): void
    {
        $repository = new FakeClienteRepository();
        $service = new ClienteService($repository);

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Cliente não encontrado');

        $service->update(
            999,
            'Teste',
            '12345678900',
            1,
            1,
            100,
            null
        );
    }

    public function test_deve_deletar_cliente(): void
    {
        $repository = new FakeClienteRepository();

        $id = $repository->create(
            'João',
            '12345678900',
            1,
            1,
            100,
            null
        );

        $service = new ClienteService($repository);

        $service->delete($id);

        $this->assertNull($repository->findById($id));
    }

    public function test_nao_deve_deletar_cliente_inexistente(): void
    {
        $repository = new FakeClienteRepository();
        $service = new ClienteService($repository);

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Cliente não encontrado');

        $service->delete(999);
    }
}

?>