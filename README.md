# 🚀 ForServos - Sistema de Ordens de Serviço

## 📌 Descrição

Sistema backend desenvolvido em PHP orientado a objetos para gerenciamento de ordens de serviço, clientes, produtos e usuários.

O sistema segue princípios de API RESTful, com autenticação via JWT, controle de acesso por roles e organização baseada em conceitos de DDD.

---

## 🛠️ Tecnologias utilizadas

* PHP 8+
* PostgreSQL
* PDO (Prepared Statements)
* JWT (firebase/php-jwt)
* PHPUnit (Testes unitários)
* Dotenv

---

## 📁 Estrutura do projeto

```
src/
├── Controllers/
├── Services/
├── Domain/
│   ├── Entities/
│   └── Repositories/
├── Infrastructure/
│   └── Repositories/
├── Middleware/
├── Core/
└── Database/
```

* **Controllers** → entrada da API
* **Services** → regras de negócio
* **Domain** → entidades e interfaces
* **Infrastructure** → acesso ao banco
* **Middleware** → autenticação e autorização
* **Core** → request, response, exceptions

---

## 🔐 Autenticação

A autenticação é feita via JWT.

### Login

```
POST /auth/login
```

### Retorno

```json
{
  "token": "jwt_token_aqui"
}
```

### Uso

Enviar no header:

```
Authorization: Bearer {token}
```

---

## 👥 Controle de acesso

O sistema utiliza roles:

* **admin**
* **user**

Rotas protegidas utilizam middleware:

* `auth` → valida token
* `role` → valida permissões

---

## 📦 Funcionalidades principais

* Cadastro de usuários
* Autenticação com JWT
* CRUD de clientes, produtos e endereços
* Criação de ordens de serviço
* Registro de logs de alterações

---

## 🔥 Regra de negócio importante

### Ordem de Serviço

Ao criar uma ordem de serviço:

* O sistema busca o cliente pelo **CPF**
* Caso não exista:

  * O cliente é criado automaticamente
* A OS é criada com o cliente vinculado
* Um log é gerado automaticamente

---

## 🧪 Testes unitários

O projeto possui testes unitários utilizando PHPUnit.

### Executar testes

```bash
vendor/bin/phpunit
```

### Cobertura atual

* UsuarioService
* ClienteService
* AuthService
* OrdemServicoService

---

## 🔒 Segurança

### SQL Injection

* Uso de **Prepared Statements (PDO)**
* Nenhuma query utiliza concatenação direta de parâmetros

### XSS

* Backend retorna apenas JSON
* Dados devem ser renderizados com segurança no frontend

---

## ⚙️ Como rodar o projeto

### 1. Clonar repositório

```bash
git clone <repo>
cd backend
```

### 2. Instalar dependências

```bash
composer install
```

### 3. Configurar `.env`

```env
DB_HOST=localhost
DB_NAME=forservos
DB_USER=postgres
DB_PASS=senha

JWT_SECRET=sua_chave_super_secreta
JWT_EXPIRATION=3600
```

### 4. Rodar servidor

```bash
php -S localhost:8000 -t public
```

---

## 📬 API Collection

O projeto possui uma collection do Postman com todas as rotas organizadas.

Sugestão de uso:

* Importar a collection
* Configurar variável `base_url`
* Utilizar login para obter token

---

## 📈 Melhorias futuras

* Swagger/OpenAPI
* Testes de integração
* Paginação nas listagens
* Refresh token
* Logs mais detalhados

---

## 👨‍💻 Autor

Cayque Guilherme
Desenvolvedor Backend
