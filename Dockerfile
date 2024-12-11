FROM php:8.3-cli

# Устанавливаем рабочую директорию
WORKDIR /app

# Устанавливаем необходимые пакеты
RUN apt-get update && apt-get install -y --no-install-recommends \
    zip unzip git curl libzip-dev \
    && docker-php-ext-install zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Копируем только composer.json и composer.lock
COPY composer.json composer.lock /app/

# Устанавливаем зависимости
RUN composer install --no-scripts --no-interaction --prefer-dist

# Копируем оставшиеся файлы проекта
COPY . /app/

# Открываем порт 8000
EXPOSE 8000

# Устанавливаем команду по умолчанию
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
