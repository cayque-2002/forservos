# ForServOs - Sistema de Ordens de Serviço

## Descrição

O **ForServOs** é um sistema para gerenciamento de ordens de serviço, clientes, produtos, usuários e entidades auxiliares.

O projeto foi desenvolvido com foco principal em **backend**, utilizando **PHP orientado a objetos**, arquitetura em camadas inspirada em **DDD**, autenticação com **JWT** e controle de acesso por **roles**.

Também inclui um **frontend em HTML estático**, utilizado para demonstrar as telas administrativas do sistema.

---

## Tecnologias utilizadas

### Backend
- PHP 8+
- PostgreSQL
- PDO
- JWT (firebase/php-jwt)
- Dotenv (vlucas/phpdotenv)
- PHPUnit

### Frontend
- HTML
- CSS
- JavaScript

---

## Estrutura do projeto
forservos/
├── backend/
│ ├── Src/
│ ├── public/
│ ├── tests/
│ ├── composer.json
│ └── .env.example
├── frontend/
│ ├── login.html
│ ├── dashboard.html
│ ├── usuarios.html
│ ├── roleusuarios.html
│ └── demais telas
└── README.md


---

## Organização do backend

- `Src/Controllers` → controle das requisições
- `Src/Services` → regras de negócio
- `Src/Domain` → entidades e contratos
- `Src/Infrastructure` → acesso a dados
- `Src/Middleware` → autenticação e autorização
- `Src/Core` → base da aplicação (request, response, exceptions)

---

## Funcionalidades

- Autenticação com JWT
- Cadastro de usuários
- Controle de acesso por roles
- CRUD de clientes
- CRUD de produtos
- CRUD de endereços
- Criação de ordens de serviço
- Registro de logs

---

## Controle de acesso

### Login
`POST /auth/login`

### Retorno

{
  "token": "jwt_token_aqui"
}

### Uso do token
Authorization: Bearer {token}

### Perfis
admin
user

### Middlewares
auth → valida JWT
role → valida permissões

### Regra de negócio
## Ordem de serviço

Ao criar uma ordem:

busca cliente pelo CPF
cria cliente automaticamente caso não exista
cria a ordem vinculada
gera log automaticamente

### Testes

Executar no diretório backend:

vendor/bin/phpunit

## Cobertura:

UsuarioService
ClienteService
AuthService
OrdemServicoService
Segurança
SQL Injection
uso de PDO com prepared statements
XSS
backend retorna JSON
sanitização é responsabilidade do frontend


### Como rodar o projeto

1. Clonar
git clone https://github.com/cayque-2002/forservos.git
cd forservos
2. Backend
cd backend
composer install

### Criar arquivo de ambiente:

cp .env.example .env

### Configurar .env:

APP_NAME=ForServOs
APP_ENV=local

DB_CONNECTION=pgsql
DB_HOST=seu_host
DB_PORT=5432
DB_DATABASE=seu_database
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha

JWT_SECRET=sua_chave_aqui
JWT_EXPIRATION=86400

### Subir servidor:

php -S localhost:8000 -t public

### Banco de dados

O projeto utiliza PostgreSQL.

É necessário:

criar o banco
executar os scripts SQL (caso incluídos)

### Frontend

O frontend é estático.

Abra os arquivos da pasta frontend/ no navegador ou use Live Server.

## Exemplos:

login.html
dashboard.html
usuarios.html
roleusuarios.html
API

### Fluxo de uso:

Fazer login
Copiar token
Enviar no header Authorization
Consumir endpoints protegidos

### Observações

O projeto não inclui credenciais reais
O .env.example serve como base de configuração
As variáveis devem ser ajustadas conforme ambiente local

### Documentação API's
Tem uma collection para importar no postman no projeto, nela vai ter todos os endpoints para testes com seus exemplos de requisição;

### Autor

Cayque Guilherme
Desenvolvedor com foco em backend