# Use an official PHP image with Apache
FROM php:8.1-apache

# Install PHP extensions (e.g., mysqli for MySQL)
RUN docker-php-ext-install mysqli

# Copy your application files into the container
COPY ./app /var/www/html

# Set the working directory
WORKDIR /var/www/html
