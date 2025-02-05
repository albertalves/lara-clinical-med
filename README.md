## Documentação da API com Swagger
### O Swagger fornecerá uma interface interativa para explorar e testar os endpoints da API.
### Para visualizar a documentação, siga os passos abaixo:

```shell
1. Certifique-se de que a aplicação está rodando.
2. Abra o navegador e acesse a URL: http://localhost:8989/api/documentation
```


## Passo a passo para executar o projeto:

### Crie o Arquivo .env
```shell
cp .env.example .env
```


###  Atualize as variáveis de ambiente do arquivo .env
```shell
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```


### Suba os containers do projeto
```shell
docker-compose up -d
```


### Acesse o container do app
```shell
docker-compose exec app bash
```


### Instalar as dependências do projeto
```shell
composer install
```


### Gerar a key do projeto Laravel
```shell
php artisan key:generate
```


### Gerar a key do JWT
```shell
php artisan jwt:secret
```


### Executar as migrations

```shell
php artisan migrate
```


### Executar os seeds

```shell
php artisan db:seed
```