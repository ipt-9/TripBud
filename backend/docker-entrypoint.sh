#!/bin/sh

# Laravel .env Cache leeren
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Falls notwendig: Datenbank-Migrationen durchführen
php artisan migrate:fresh --seed

# Starte den Laravel Server
php artisan serve --host=0.0.0.0 --port=8000
