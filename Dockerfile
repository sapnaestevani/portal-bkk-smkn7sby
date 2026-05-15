FROM php:8.2-cli

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set folder kerja
WORKDIR /app

# Copy semua file project
COPY . .

# Railway kasih PORT lewat environment
CMD php -S 0.0.0.0:$PORT