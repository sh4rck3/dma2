

## Sobre o Projeto
Passo 01: Clonar o repositorio
git clone URL.git "nome da pasta"

Passo 02: Parametrização do Projeto
Copiar o .env.example e renomear a cópia para .env
Preencher as informações de dentro o arquivo

Passo 03: Instalação das dependencias do projeto
instalação das dependencias do projeto com o comando "composer install" para instalar dependencias do PHP e "npm install" para instalar as dependencias dos Java Script

Passo 04: Criando a tabela 
rode o comando "php artisan migrate" para criar as tabelas
"php artisan db:seed" para popular o banco

Passo 05: Gerar a key
Comando "php artisan key:generate"
Depois buildar o projeto com o comando "npm run build"

Passo 06: Rodando o servidor local
"php artisan serve" para rodar o servidor local
E "npm run dev" para fazer alterações em tempo real no projeto