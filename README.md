# ProjetoJunior

## Como rodar o projeto localmente

# Clonar o repositório
git clone https://github.com/GabrielMota08/ProjetoJunior.git
cd ProjetoJunior

# Instalar dependências
composer install

# Inicializar o MySQL (no Windows, pelo cmd com permissão de administrador)
net start mysql80

# Criar o arquivo .env e gerar a chave da aplicação
cp .env.example .env
php artisan key:generate

# Rodar as migrations para criar as tabelas no banco
php artisan migrate

# Iniciar o servidor local
php artisan serve

# Acesse no navegador
http://localhost:8000
