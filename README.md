Инструкция по запуску

Клонировать репозиторий:
git clone <repository_url>
cd <repository_folder>

Собрать Docker-образ 
docker build -t loan-issuer .

Запустить контейнер
docker run -p 8000:8000 -v $(pwd):/app --name loan-issuer loan-issuer

Запустить консольное приложение
docker exec -it loan-issuer php bin/console app:ui

Запуск phpstan (опционально)
vendor/bin/phpstan analyse

Запуск тестов (опционально)
vendor/bin/phpunit --testdox
