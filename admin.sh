#!/bin/bash

# Tworzenie roli admin (jeśli nie istnieje) i użytkownika admin@example.com z hasłem admin123
php artisan tinker --execute="Spatie\\Permission\\Models\\Role::firstOrCreate(['name' => 'admin']); App\\Models\\User::firstOrCreate(['email' => 'admin@example.com'], ['name' => 'Admin', 'password' => Hash::make('admin123'), 'email_verified_at' => now()])->assignRole('admin')"

echo "Admin user created: admin@example.com / admin123" 