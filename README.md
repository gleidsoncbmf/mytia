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

Copie o arquivo `.env` e `.env.testing` disponiblizados por e-mail para a pasta raiz do projeto que você clonou.


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

### 6️⃣ Api Disponível

Após os comandos, a api estará disponível na seguinte rota:
```bash
http://127.0.0.1:80/api
```
### 📡 POSTMAN e Rotas

A partir de agora, trabalharemos as requisições atráves do PostMan, o arquivo Json para importação com as rotas já salvas, está disponível no repositorio do projeto, e no e-mail enviado. Baixe o arquivo e faça a importação no PostMan, para facilitar o uso da Api.

Lembre-se de marcar o check key Accept no Headers e selecionar application/json em Value, trabalharemos no postman com requisições via json e Bearer token authorization. Se preferir, também pode passar o token no header. 

###1️⃣ Criação de Usuários

Rota: 
```bash
http://127.0.0.1:8000/api/register
```
Metodo: POST
Os parametros para criação de um usuário através dessa rota são, por exemplo:
    
```json
{
    "name": "usuario 1",
    "email" : "usuario@email.com",
    "password" : "123",
    "pawword_confirmation" : "123",
    "role" : "(pode ser "admin, "moderador, ou "user")"
}
```

OBS 1: Essa rota não contém restrição pois foi considerado o uso dela para criação de usuarios em geral para fins de teste, mas nada impede de que seja restrita caso seja solicitado.

OBS 2: Sempre que um usuário é criado é gerado um token, da mesma forma que sempre que um usuário faz login também é gerado um token, e quando o usuário faz logout os tokens são deletados. Os Tokens serão utilizados para autenticação na aplicação.

###2️⃣Login

Rota:
```bash
http://127.0.0.1:8000/api/login
```
Método: POST

O usuário deve utilizar seu e-mail e senha para realizar login na aplicação, por exemplo:
```json
{
    "email": "usuario@email.com",
    "password" : "123"
}
```

OBS 1: Ao fazer Login Séra gerado um token.

###3️⃣Logout:
Rota:
```bash
http://127.0.0.1:8000/api/logout
```
Método: POST

Para fazer logou o usuário deve utilizar o token gerado durante o login:
- Ir na aba Authorization
- Em Auth Type selecionar: Bearer Token
- Em Token , Colar o token gerado anteriormente e enviar a requisição
- Com isso o usuário conseguirar encerrar a sessão

OBS 1: Caso o Token seja diferente do obtido anteriormente, não haverá autorização para encerrar a sessão

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
