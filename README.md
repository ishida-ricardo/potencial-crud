# Desafio - pontential-crud

## Tecnologias
* Laravel 8 
* PHP 8
* Nginx
* MySql
* ReactJS
* Docker

## Como utilizar
Para levantar container com a aplicação:

    $ git clone https://github.com/ishida-ricardo/potencial-crud.git <sua-pasta>
    $ cd <sua-pasta> && docker-compose up --build -d
    $ docker-compose exec backend sh -c "composer install"
    $ docker-compose exec backend sh -c "php artisan migrate"

Este procedimento irá disponibilizar a aplicação nos seguintes endereços:

* api: http://localhost:8000/
* frontend: http://localhost:3000/

Para executar os testes automatizados:

    $ docker-compose exec backend sh -c "./vendor/bin/phpunit --testdox"
