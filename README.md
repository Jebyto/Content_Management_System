Claro! Aqui está o README.md com as seções em inglês adicionadas:

---

# REST API with Laravel for Post Creation

Esta é uma REST API desenvolvida em Laravel para a criação de posts, com usuários autenticados e a capacidade de adicionar tags aos posts para facilitar a busca por tags específicas.

## Pré-requisitos (Prerequisites)

Antes de começar, certifique-se de ter o seguinte instalado em sua máquina:

- PHP (recomendado o uso do [Laragon](https://laragon.org/) para ambiente de desenvolvimento)
- Composer

## Instalação (Installation)

Siga estes passos para configurar e executar o projeto localmente:

1. Clone este repositório (Clone this repository):

    ```bash
    git clone https://github.com/Jebyto/Content_Management_System.git
    ```

2. Instale as dependências do projeto usando o Composer (Install project dependencies):

    ```bash
    composer install
    ```

3. Configure o ambiente do projeto copiando o arquivo `.env.example` para `.env` (Configure project environment):

    ```bash
    cp .env.example .env
    ```

4. Gere a chave de aplicativo (Generate application key):

    ```bash
    php artisan key:generate
    ```

5. Execute as migrações do banco de dados e o seeder (opcional) (Run database migrations and seeder - optional):

    ```bash
    php artisan migrate --seed
    ```

6. Inicie o serviço (Start Service):

    ```bash
    php artisan serve
    ```

## Documentação da API (API Documentation)

A documentação da API está disponível através do Swagger. Você pode acessá-la em (API documentation is available via Swagger. You can access it at):

[http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

Ou sua porta escolhida (Or your choosen port):
http://localhost:{port}/api/documentation

## Mensagens Importantes (Important Messages)

- Certifique-se de configurar corretamente o arquivo `.env` com suas configurações de banco de dados (Make sure to configure the `.env` file correctly with your database settings).
- Mantenha suas credenciais de acesso ao banco de dados seguras (Keep your database access credentials secure).
- Sempre valide os dados de entrada para garantir a segurança da sua aplicação (Always validate input data to ensure application security).
- O código fonte da REST API está escrito em inglês, como variáveis por exemplo, para facilitar a leitura de estrangeiros. Ter um conhecimento básico de inglês é recomendado para entender o projeto.

## Sobre a API (About the API)

Esta API foi desenvolvida usando o framework Laravel, que é um framework PHP moderno e poderoso. Laravel fornece uma estrutura robusta para o desenvolvimento rápido de aplicativos web, com recursos como autenticação, roteamento, Eloquent ORM e muito mais (This API was developed using the Laravel framework, which is a modern and powerful PHP framework. Laravel provides a robust framework for rapid web application development, with features like authentication, routing, Eloquent ORM, and more).

## Tecnologias Utilizadas (Technologies Used)

- Laravel
- PHP
- Composer

---

Sinta-se a vontade para contribuir (Feel free to contribute).
