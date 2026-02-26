#!/bin/bash

echo "🚀 Starting Docker..."
./vendor/bin/sail up -d

echo "⏳ Waiting container..."
sleep 8

if [ ! -f .env ]; then
  echo "📄 Copying .env..."
  cp .env.example .env
fi

echo "📦 Installing Composer..."
./vendor/bin/sail composer install

echo "📦 Installing NPM..."
./vendor/bin/sail npm install

echo "🏗 Building frontend..."
./vendor/bin/sail npm run build

echo "🔑 Generating key..."
./vendor/bin/sail artisan key:generate

echo "🗄 Running migrations..."
./vendor/bin/sail artisan migrate --seed

echo "🧹 Clearing cache..."
./vendor/bin/sail artisan optimize:clear

echo "✅ DONE!"
echo "🌍 Open: http://localhost"