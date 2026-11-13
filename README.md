# LifeCare

LifeCare is Lifemedia's internet and Wi-Fi complaint service, built with Laravel. Customers can report connection and equipment problems, track handling progress, and download their complaint history. Admins can manage categories, create technician accounts, assign tickets, and download reports. Technicians can view only their assigned tickets and update handling status and notes for customers.

## Requirements

- PHP 8.1 or later
- Composer
- MySQL

## Setup

1. Install PHP dependencies with `composer install`.
2. Copy `.env.example` to `.env` and set your database credentials.
3. Create the configured MySQL database (`CREATE DATABASE sigap_desa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`), then run `php artisan key:generate`.
4. Run `php artisan migrate --seed`.
5. Create the public uploads link with `php artisan storage:link`.
6. Start the local server with `php artisan serve`.

The seed data creates an administrator account (`admin@lifemedia.test` / `admin123`), a customer account (`pelanggan@lifecare.test` / `pelanggan123`), and a technician account (`teknisi@lifemedia.test` / `teknisi123`). Admins can create additional technician accounts from **Admin → Teknisi**, then assign technicians from a ticket's detail page.
