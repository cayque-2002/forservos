<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use Src\Services\OrdemServicoService;
use Src\Core\HttpException;
use Tests\Fakes\FakeClienteRepository;
use Tests\Fakes\FakeOrdemServicoLogRepository;
use Tests\Fakes\FakeOrdemServicoRepository;

class OrdemServicoServiceTest extends TestCase
{
    public function test_deve_criar_ordem_de_servico_com_cliente_existente(): void
    {
        $ordemRepository = new FakeOrdemServicoRepository();
        $logRepository = new FakeOrdemServicoLogRepository();
        $clienteRepository = new FakeClienteRepository();

        $clienteId = $clienteRepository->create(
            'João da Silva',
            '12345678900',
            1,
            1,
            100,
            null
        );

        $service = new OrdemServicoService(
            $ordemRepository,
            $logRepository,
            $clienteRepository
        );

        $ordemId = $service->create(
            1001,
            1,
            1,
            'Equipamento com defeito',
            [
                'nomeCliente' => 'João da Silva',
                'cpf' => '12345678900'
            ],
            1
        );

        $this->assertEquals(1, $ordemId);
        $this->assertCount(1, $ordemRepository->ordens);
        $this->assertEquals($clienteId, $ordemRepository->ordens[0]['clienteid']);
        $this->assertCount(1, $logRepository->logs);
        $this->assertEquals('CREATE', $logRepository->logs[0]['acao']);
    }

    public function test_deve_criar_cliente_automaticamente_se_nao_existir(): void
    {
        $ordemRepository = new FakeOrdemServicoRepository();
        $logRepository = new FakeOrdemServicoLogRepository();
        $clienteRepository = new FakeClienteRepository();

        $service = new OrdemServicoService(
            $ordemRepository,
            $logRepository,
            $clienteRepository
        );

        $ordemId = $service->create(
            1002,
            1,
            1,
            'Novo cliente criado automaticamente',
            [
                'nomeCliente' => 'Maria Oliveira',
                'cpf' => '99999999999',
                'situacaoClienteId' => 1,
                'enderecoId' => 1,
                'numeroEndereco' => 200,
                'complementoCliente' => 'Casa B'
            ],
            1
        );

        $this->assertEquals(1, $ordemId);
        $this->assertCount(1, $clienteRepository->clientes);
        $this->assertCount(1, $ordemRepository->ordens);
        $this->assertEquals(1, $ordemRepository->ordens[0]['clienteid']);
        $this->assertCount(1, $logRepository->logs);
    }

    public function test_nao_deve_criar_ordem_com_numero_duplicado(): void
    {
        $ordemRepository = new FakeOrdemServicoRepository();
        $logRepository = new FakeOrdemServicoLogRepository();
        $clienteRepository = new FakeClienteRepository();

        $ordemRepository->create(
            1001,
            1,
            1,
            1,
            1,
            'OS já existente'
        );

        $service = new OrdemServicoService(
            $ordemRepository,
            $logRepository,
            $clienteRepository
        );

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Já existe ordem de serviço com este número');

        $service->create(
            1001,
            1,
            1,
            'Tentativa duplicada',
            [
                'nomeCliente' => 'João da Silva',
                'cpf' => '12345678900',
                'situacaoClienteId' => 1,
                'enderecoId' => 1,
                'numeroEndereco' => 100
            ],
            1
        );
    }

    public function test_nao_deve_criar_cliente_automaticamente_sem_dados_obrigatorios(): void
    {
        $ordemRepository = new FakeOrdemServicoRepository();
        $logRepository = new FakeOrdemServicoLogRepository();
        $clienteRepository = new FakeClienteRepository();

        $service = new OrdemServicoService(
            $ordemRepository,
            $logRepository,
            $clienteRepository
        );

        $this->expectException(HttpException::class);
        $this->expectExceptionMessage('Dados do cliente insuficientes para cadastro automático');

        $service->create(
            1003,
            1,
            1,
            'Cliente incompleto',
            [
                'cpf' => '88888888888'
            ],
            1
        );
    }

    public function test_deve_gerar_log_ao_criar_ordem(): void
    {
        $ordemRepository = new FakeOrdemServicoRepository();
        $logRepository = new FakeOrdemServicoLogRepository();
        $clienteRepository = new FakeClienteRepository();

        $clienteRepository->create(
            'Carlos Pereira',
            '77777777777',
            1,
            1,
            50,
            null
        );

        $service = new OrdemServicoService(
            $ordemRepository,
            $logRepository,
            $clienteRepository
        );

        $service->create(
            1004,
            1,
            1,
            'Teste de log',
            [
                'nomeCliente' => 'Carlos Pereira',
                'cpf' => '77777777777'
            ],
            1
        );

        $this->assertCount(1, $logRepository->logs);
        $this->assertEquals('CREATE', $logRepository->logs[0]['acao']);
        $this->assertArrayHasKey('after', $logRepository->logs[0]['dados']);
    }
}

?>