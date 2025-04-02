# 📌 Mytia

API para cadastro e avaliação de produtos, com implementação para gerenciar usuários e permissões.  

## 🚀 Tecnologias Utilizadas

- PHP (Laravel 12)
- NPLCloud (API) 
- GraphQL (Lighthouse)
- Docker
- MySQL
- Sanctum (Autenticação)
- PHP Unit (Testes)

## 📦 Instalação e Configuração

### 1️⃣ Clonar o Repositório

Clone o repositório do Projeto:

```bash
git clone https://github.com/gleidsoncbmf/mytia
```

### 2️⃣ Configurar as Variáveis de Ambiente

Copie o arquivo `.env` e `.env.tensting` para a pasta raiz do projeto que você clonou.


### 3️⃣ Instalar as Dependências

As dependências e requisitos serão instalados ao subir o container. O Dockerfile contém os comentários das instruções utilizadas.

Abra o terminal na pasta raiz do projeto e execute o Comando:

```bash
docker-compose up -d --build
```

### 4️⃣ Gerar a Chave da Aplicação

Utilize o comando para gerar a chave da aplicação:

```bash
docker-compose run --rm mytia_web php artisan key:generate
```

### 5️⃣ Execute as migrações 

```bash
docker-compose run --rm mytia_web php artisan migrate
```

### 6️⃣ Iniciar o Servidor

```bash
php artisan serve
```

## 🔐 Autenticação e Segurança

A API utiliza Laravel Sanctum para autenticação via tokens. Para acessar rotas protegidas, inclua o token no header:

```bash
Authorization: Bearer SEU_TOKEN_AQUI
```

## 📊 GraphQL - Consultas e Mutations

A API possui suporte a GraphQL através do Lighthouse.

### 🔍 Exemplo de Query para Listar Produtos:

```json
{
  "query": "{ produtos { id nome valor } }"
}
```

### 🔍 Exemplo de Query para Listar Produto com Avaliações:

```json
{
  "query": "{ produto(id: 1) { id nome valor avaliacoes { comentario sentimento user { name email } } } }"
}
```

## 🧪 Testes

Para rodar os testes:

```bash
php artisan test
```

## 📜 Licença

Este projeto está licenciado sob a MIT License - veja o arquivo LICENSE para mais detalhes.
