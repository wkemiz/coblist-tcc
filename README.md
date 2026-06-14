# Sistema de Cobrança - Laravel

# Descrição do Projeto
Sistema de gerenciamento de clientes e cobranças desenvolvido em **Laravel 10**.  
Permite controlar clientes, acordos mensais ("colchão"), aplicar filtros, calcular H.O (honorário de pagamento) automaticamente e proteger páginas com login.

O objetivo do sistema é facilitar o controle de pagamentos, acordos e honorários, de forma prática e visualmente limpa.


# Funcionalidades

- CRUD de Clientes: Cadastrar, editar, excluir e listar clientes.
- Filtros inteligentes:
  - Credor: COBMAIS, BONUSCRED
  - Colchão: Sim / Não
- Cálculo de H.O (Honorários):
  - Fase 15% ou 20%: cálculo automático com base no valor do cliente.
  - Fase 0%: valor manual digitado pelo usuário.
- Aba Colchão: Exibe clientes com acordos mensais, próxima data de vencimento e status (Ativo/Pendente).
- Autenticação: Login/logout protegendo todas as páginas do sistema.
- Layout clean e responsivo: Cores pastel, fácil navegação.
- Validações de formulário: CPF único, campos obrigatórios e mensagens de erro.


# Rotas do Sistema

 Rotas abertas (sem login)
 Método | URL       | Descrição       
 GET    | /login    | Formulário login
 POST   | /login    | Processa login  

# Rotas protegidas (login obrigatório)
 Método | URL                  | Descrição                
 GET    | /                    | Lista de clientes       
 GET    | /clientes           | Lista de clientes       
 GET    | /clientes/novo      | Formulário novo cliente
 POST   | /clientes           | Salva novo cliente      
 GET    | /clientes/{id}/editar | Edita cliente          
 PUT    | /clientes/{id}      | Atualiza cliente        
 DELETE | /clientes/{id}      | Exclui cliente          
 GET    | /colchao            | Clientes com colchão    
 POST   | /logout             | Logout                  


#  Tecnologias Usadas
- Backend: PHP 8.2, Laravel 10  
- Banco de Dados: MySQL  
- Frontend: Blade, HTML, CSS, JavaScript  


# Usuário de Teste
- Email: `admin@teste.com`  
- Senha: `12345678`

# Como Rodar Localmente
1. Clone o projeto:  
```bash
git clone <url-do-repo>
cd sistema-cobranca
Instale as dependências do PHP/Laravel: composer install
configuração .env
APP_NAME=SistemaDeCobranca
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_cobranca
DB_USERNAME=root
DB_PASSWORD=
Gere a chave do aplicativo: php artisan key:generate
Rode as migrations para criar as tabelas no banco: php artisan migrate
Rode o servidor local: php artisan serve
O sistema ficará disponível em http://127.0.0.1:8000.

# Acesso
Para acessar o sistema, use o usuário de teste fornecido acima.