FROM php:8.2-apache

# Habilitar mod_rewrite de Apache y establecer el ServerName
RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Instalar las extensiones de PHP necesarias para conectar a MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copiar todos los archivos del proyecto al directorio público de Apache
COPY . /var/www/html/

# Asegurar que el servidor web tenga permisos para leer/escribir en el directorio data (para el fallback de JSON)
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 775 /var/www/html/data

# Exponer el puerto 80
EXPOSE 80
