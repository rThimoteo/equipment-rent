# Sistema de Locação de Equipamentos

Aplicação web para gerenciamento de locações de equipamentos. Permite cadastrar itens, verificar disponibilidade por período e registrar locações com cálculo automático de valores.

## Tecnologias Utilizadas

- Laravel 12
- PHP 8.4
- MySQL
- jQuery
- Tailwind CSS

## Funcionalidades

- Cadastro de Equipamentos (nome, descrição, valor da diária)
- Listagem de equipamentos disponíveis por data
- Criação de pedidos de locação com seleção de datas e cálculo automático do valor total
- Exibição de todos os pedidos realizados
- Edição e cancelamento de locações
- Filtros por data, nome e disponibilidade (Equipamentos)
- Validações básicas no front (jQuery) e no backend (FormRequest)
- Testes automatizados simpoles para os controllers

## Como Rodar o Projeto

1. Clone o repositório:
   ```bash
    git clone https://github.com/rThimoteo/equipment-rent.git
    cd equipment-rent
   ```
2. Instale as dependências PHP e JS::
   ```bash
    composer install
    npm install
   ```
3. Configure o .env:
   ```bash
    cp .env.example .env
    php artisan key:generate
   ```
4. Ajuste a conexão com o banco no .env e rode as migrations/seeders:
   ```bash
   php artisan migrate --seed
   ```
5. Inicie o Vite:
   ```bash
    npm run dev
   ```
6. Inicie o Laravel:
   ```bash
    php artisan serve
   ```
7. Acesse: http://localhost:8000