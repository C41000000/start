# Usa a imagem oficial do PHP 8.5 FPM
FROM php:8.5-fpm

# Define o diretório de trabalho padrão dentro do container
WORKDIR /var/www

# INSTALA AS DEPENDÊNCIAS (Adicionado o libicu-dev para o intl funcionar)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libpq-dev \
    libicu-dev

# Limpa o cache do apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala as extensões do PHP (Agora o intl vai passar também)
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip intl

# Instala a extensão do Redis
RUN pecl install redis && docker-php-ext-enable redis

# Pega o binário do Composer mais recente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia os arquivos do seu projeto
COPY . /var/www

# Ajusta as permissões das pastas que o Laravel precisa escrever
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Expõe a porta 9000 e inicia o processo
EXPOSE 9000
CMD ["php-fpm"]
