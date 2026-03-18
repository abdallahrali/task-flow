# Start with the official PHP 8.2 Apache image
FROM php:8.2-apache

# Install the PDO and MySQL extensions required for TaskFlow
RUN docker-php-ext-install pdo pdo_mysql

# Give Apache the correct permissions
RUN chown -R www-data:www-data /var/www/html