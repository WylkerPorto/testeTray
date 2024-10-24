# Teste Tray

Foi criado essa aplicação para analise de vaga de desenvolvedor Pleno Laravel + Vue, ela consiste em uma aplicação separada entre aplicação e api com conexão usando o modelo Rest a aplicação contém crud de vendedores e vendas, além da listagem separada de vendas de um vendedor por data.

Na aplicação está sendo autenticado por JWT a integração com a api e mantendo os padrões de rotas e status de resposta, além de aplicar os métodos de fila, envio de email, agendamento e jobs para conseguir suprir os requisitos do teste.

Além da aplicação pedida, como extras foram feitos os outros métodos como atualização e deleção de conteúdo mantendo o padrão de soft delete no vendedor para não perder informações relevantes para a venda, teste basicos de acesso as rotas e suas funções e validação dos dados recebidos.

## Estrutura do Projeto

/project-root 

├── backend/              # Código do backend (Laravel)

│   └── Dockerfile        # Dockerfile para o backend

├── frontend/             # Código do frontend (Vue) 

│   └── Dockerfile        # Dockerfile para o frontend

├── docker-compose.yml    # Arquivo Docker Compose 

└── nginx.conf            # Arquivo de configuração do Nginx
## Pré-requisitos

Antes de começar, você precisará ter o seguinte instalado em sua máquina:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Instalação

1. **Clone o repositorio**

```bash
git clone https://github.com/WylkerPorto/testeTray
cd testeTray
```

2. **Suba os containers**

```bash
docker-compose up -d
```

Para acessar o Container do Laravel (API):

    docker exec -it api bash

Para acessar o container do Vue (Web):

    docker exec -it web bash

## Instalação do Laravel

Instale as dependências do Laravel:

Após acessar o container do Laravel, execute:

    composer install

Copie o arquivo de ambiente:

    cp .env.example .env

Gere a chave de aplicação:

    php artisan key:generate

Gere a chave de autenticação:

    php artisan jwt:secret

Configuração do Banco de Dados:

Edite o arquivo .env e configure as informações do banco de dados e fila. Por exemplo:

    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=traydb
    DB_USERNAME=root
    DB_PASSWORD=root

    QUEUE_CONNECTION=database

Execute as Migrations e Seeders:

Para criar as tabelas no banco de dados:

    php artisan migrate

Para popular o banco de dados com dados iniciais:

    php artisan db:seed

Para inserir o Admin execute o seed especifico:

    php artisan db:seed --class=AdminUserSeeder

Inicie o Queue Worker (opcional):

Para iniciar as filas:

    php artisan queue:work

## Acessando a Aplicação

As credenciais de acesso são:

login:

    local@host.com

senha:

    admin123

- [Frontend (Vue)](http://localhost)
- [Backend (Laravel)](http://localhost/api)

## Parando os Containers

Para parar os containers, execute:

    docker-compose down

## Testes

Caso queira executar os testes implementados

- acesse o container da api e execute

```
php artisan test
```
