#!/bin/sh

# Cross-platform script for Mac, Linux, and Windows (Git Bash/WSL)

# Step 1: Fresh migrate
php artisan migrate:fresh --seed
if [ $? -ne 0 ]; then
  echo "Migration failed. Exiting."
  exit 1
fi

# Step 2: Generate all Filament Shield permissions
php artisan shield:generate --all
if [ $? -ne 0 ]; then
  echo "Filament Shield generation failed. Exiting."
  exit 1
fi

# Step 3: Run UserSeeder
php artisan db:seed --class=UserSeeder
if [ $? -ne 0 ]; then
  echo "UserSeeder failed. Exiting."
  exit 1
fi

echo "All steps completed successfully!" 