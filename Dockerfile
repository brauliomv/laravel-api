#Versión de php a usar en la imagen, estoy usando la 8.2
FROM php:8.2-apache

# Configurar Apache para permitir el acceso a los archivos
RUN echo "<Directory /var/www/html>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/laravel.conf && \
    a2enconf laravel


# Instala extensiones de PHP necesarias para Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Copia los archivos del proyecto al contenedor
COPY . /var/www/html

# Establece permisos
RUN chown -R www-data:www-data /var/www/html

# Instala Composer
COPY --from=composer:2.7.7 /usr/bin/composer /usr/bin/composer

# Instala dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Exponer el puerto 80 para la aplicación
EXPOSE 80

# Establece el directorio de trabajo
WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configurar el DocumentRoot de Apache en el directorio public de Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

RUN echo "DirectoryIndex index.php" >> /etc/apache2/apache2.conf

RUN a2enmod rewrite
