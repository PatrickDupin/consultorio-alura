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
   - [ ] Tratamento de erros
   - [ ] Cache
   - [ ] Logs
   - [ ] Testes



## Requisitos para rodar este Projeto:
 - PHP versão 7.2 ou superior;
 - Composer
 - MYSql

### Após baixar o projeto, será necessário seguir os seguintes passos:
 - Configurar o acesso ao seu banco de dados através do arquivo `.env`;
 - Baixar todas as  dependências e componentes:
   - `composer install`;
 - Criar o banco de dados:
   - `php bin/console doctrine:database:create`
 - Rodar as *migrations*:
   - `php bin/console doctrine:migrations:migrate`
