### Инструкция запуска тестового проекта

Update your vendor packages

    docker-compose run --rm php composer update --prefer-dist
    
Run the installation triggers (creating cookie validation code)

    docker-compose run --rm php composer install    
    
Запустить контейнеры

    docker-compose up
    
Установить базу данных и запустить миграции
    
    docker-compose exec php yii migrate
    
Открыть в браузере:

    http://127.0.0.1:8000
