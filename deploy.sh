#!/bin/bash

# Set variables
PROJECT_DIR="$(pwd)"
HEALTHCHECK_URL="https://api.thegymclubhouse.com"  # Adjust to your domain
APP_ENV="production"
DB_PASSWORD="ESQfHj/Fk-kk"  # Replace with actual password

echo "🚀 Starting Laravel deployment script..."

# Set Git configuration for GitHub
echo "🔧 Configuring Git settings..."
git config pull.rebase false
git config --global user.email "jbnyamasheki@gmail.com"
git config --global user.name "slymackjr"

# Ensure we're in the project directory
cd "$PROJECT_DIR" || { echo "❌ Failed to navigate to project directory!"; exit 1; }

# Check PHP version and extensions
echo "🔍 Checking PHP requirements..."
PHP_VERSION=$(php -r "echo PHP_VERSION;")
REQUIRED_EXTENSIONS=("mbstring" "openssl" "pdo" "tokenizer" "xml")

echo "🔍 PHP version: $PHP_VERSION"
for ext in "${REQUIRED_EXTENSIONS[@]}"; do
    php -m | grep -q "$ext" || { echo "❌ Required PHP extension $ext is missing!"; exit 1; }
done

# Pull the latest changes from Git
echo "📥 Pulling latest changes..."
git pull origin master || { echo "❌ Failed to pull latest changes!"; exit 1; }

# If .env doesn't exist, copy from .env.example
if [ ! -f ".env" ]; then
    echo "⚠️ .env file not found. Copying from .env.example..."
    cp .env.example .env || { echo "❌ Failed to create .env from .env.example!"; exit 1; }
fi

# Escape special characters in password for sed
ESCAPED_PASSWORD=$(printf '%s\n' "$DB_PASSWORD" | sed -e 's/[\/&]/\\&/g')

# Update .env file with DB password and timezone
echo "🔧 Updating environment variables in .env..."
sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=$ESCAPED_PASSWORD/" .env
sed -i "s/^APP_TIMEZONE=.*/APP_TIMEZONE=Africa\/Dar_es_Salaam/" .env

# Install PHP dependencies via Composer
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader || { echo "❌ Composer install failed!"; exit 1; }

# Generate Laravel application key
echo "🔑 Generating Laravel application key..."
php artisan key:generate --force || { echo "❌ Artisan key:generate failed!"; exit 1; }

# Install frontend assets if package.json exists
if [ -f "package.json" ]; then
    echo "📦 Installing frontend dependencies..."
    npm install || { echo "❌ Frontend dependencies installation failed!"; exit 1; }
fi

# Run Laravel artisan commands to set up the database
echo "🔨 Running Laravel artisan commands..."
php artisan migrate:refresh --seed || { echo "❌ Artisan migrate failed!"; exit 1; }

# Health check to verify site is responding
echo "🌐 Checking if $HEALTHCHECK_URL is online..."
if curl -s --head --request GET "$HEALTHCHECK_URL" | grep "200 OK" > /dev/null; then
    echo "✅ $HEALTHCHECK_URL is online. Deployment succeeded."
else
    echo "⚠️ $HEALTHCHECK_URL is not responding properly. Please check your application."
fi

echo "✅ Laravel deployment completed successfully!"
