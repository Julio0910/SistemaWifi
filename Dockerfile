# Usamos como base la imagen oficial de PHP 8.2 con FPM.
FROM php:8.2-fpm

# Establecemos el directorio de trabajo dentro del contenedor.
WORKDIR /var/www/html

# Instalamos las dependencias del sistema y las extensiones de PHP que Laravel necesita.
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath

# Instalamos Composer (el gestor de paquetes de PHP).
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cambiamos el propietario de los archivos al usuario con el que corre el servidor web.
RUN chown -R www-data:www-data /var/www/html