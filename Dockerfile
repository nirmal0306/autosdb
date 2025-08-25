# Use official PHP image with Apache
FROM php:8.2-apache

# Copy all files from current folder to container's web directory
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Expose port 80 for web traffic
EXPOSE 80

# Optional: Enable PHP extensions if needed
# RUN docker-php-ext-install mysqli pdo pdo_mysql

# Apache runs automatically in this image
