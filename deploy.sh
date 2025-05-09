#!/bin/bash

# Configuration
PROJECT_DIR="$(pwd)"
APP_ENV="production"
DB_HOST="localhost"
DB_PORT="3306"
DB_DATABASE="gym-clubhousedb"   
DB_USERNAME="joker"     
DB_PASSWORD="JErry#code0987!"  
APP_TIMEZONE="Africa/Dar_es_Salaam"

# Deployment steps
cd "$PROJECT_DIR" || { echo "Failed to enter project directory"; exit 1; }

# Git operations
echo "Updating code from repository..."
git pull origin master || { echo "Git pull failed"; exit 1; }

# Environment setup
if [ ! -f ".env" ]; then
    cp .env.example .env || { echo "Failed to create .env file"; exit 1; }
fi

# Update .env file
echo "Configuring environment..."
sed -i \
    -e "s|^DB_HOST=.*|DB_HOST=$DB_HOST|" \
    -e "s|^DB_PORT=.*|DB_PORT=$DB_PORT|" \
    -e "s|^DB_DATABASE=.*|DB_DATABASE=$DB_DATABASE|" \
    -e "s|^DB_USERNAME=.*|DB_USERNAME=$DB_USERNAME|" \
    -e "s|^DB_PASSWORD=.*|DB_PASSWORD=$DB_PASSWORD|" \
    -e "s|^APP_TIMEZONE=.*|APP_TIMEZONE=$APP_TIMEZONE|" \
    -e "s|^APP_ENV=.*|APP_ENV=$APP_ENV|" \
    .env

# Install composer if missing
if ! command -v composer &> /dev/null; then
    echo "Installing composer..."
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    php -r "unlink('composer-setup.php');"
fi    

# Dependency management
echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader || { echo "Composer install failed"; exit 1; }

[ -f "package.json" ] && {
    echo "Installing frontend dependencies..."
    npm install || { echo "NPM install failed"; exit 1; }
}

# Laravel specific commands
echo "Running Laravel optimizations..."
php artisan key:generate --force || { echo "Key generation failed"; exit 1; }
php artisan migrate --force || { echo "Migration failed"; exit 1; }
php artisan optimize:clear || { echo "Cache clear failed"; exit 1; }

# Cache warmup
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Permission fixes
echo "Setting permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "Deployment completed successfully!"
