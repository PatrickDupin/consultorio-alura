# API REST com Symfony

## Desenvolvimento de uma API padrão REST para aplicação de um Consultório Médico.
Funcionalidades:
 - [x] Parte 1
   - [x] CRUD Médicos
   - [x] CRUD Especialidades
 - [x] Parte 2
   - [x] Filtros
   - [X] Paginação
   - [x] Autenticação
 - [ ] Parte 3
   - [x] Tratamento de erros
   - [x] Cache
   - [ ] Logs
   - [ ] Testes



## Requisitos para rodar este Projeto:
 - PHP versão 7.2 ou superior;
 - Composer
 - MYSql

### Após baixar o projeto, será necessário seguir os seguintes passos:
 - Configurar o acesso ao seu banco de dados por meio do parâmetro `DATABASE_URL` do arquivo `.env`;
 - Baixar todas as  dependências e componentes:
   - `composer install`;
 - Habilitar a extensão `pdo_mysql` em sua instalação do PHP, caso seja necessário;
 - Através da linha de comando de seu S.O.:
   - Criar o banco de dados:
     - `php bin/console doctrine:database:create`
   - Rodar as *migrations*:
     - `php bin/console doctrine:migrations:migrate`
   - Subir o servidor web PHP (a porta 8080 pode ser alterada para a porta que desejar)
     - `php -S localhost:8080 -t public`

### A aplicação está pronta para ser executada!
