# Tun Rice Milling

Tun Rice Milling is a Laravel-based rice milling management system for handling merchant intake, appointment scheduling, drying and milling workflows, result tracking, and report generation.

## Overview

The application provides two main portals:

- Admin portal for managing users, roles, permissions, merchants, paddy types, appointment types, processing records, results, and reports.
- Merchant portal for registering paddies, booking appointments, viewing results, and exporting personal reports.

Core business areas implemented in the codebase include:

- Paddy registration and tracking
- Appointment booking with availability checks
- Drying and milling process management
- Milling output prediction
- Result calculation and storage
- PDF report exports
- Queued email notifications
- Role and permission management with Spatie Laravel Permission

## Tech Stack

- PHP 8.2+
- Laravel 12
- MySQL or another Laravel-supported relational database
- Vite
- Tailwind CSS
- Alpine.js
- Pest for testing
- DomPDF for PDF exports

## Main Modules

### Admin

- Dashboard
- User, role, and permission management
- Merchant management
- Paddy type, appointment type, and result type management
- Appointment confirmation and cancellation
- Drying and milling record management
- Result management
- Operational and performance reports with PDF export

### Merchant

- Dashboard
- Paddy registration
- Appointment booking and cancellation
- Drying result calculation
- Milling result calculation
- Result history
- Appointment and paddy-processing reports with PDF export

## Installation

### 1. Install dependencies

```bash
composer install
npm install
```

### 2. Create environment file

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configure the database

Update the database settings in `.env` for your local environment, then run:

```bash
php artisan migrate --seed
```

The default queue connection in this project is `database`, so make sure your migrations are applied before processing queued jobs.

### 4. Start the application

For the full local development stack:

```bash
composer run dev
```

This starts:

- Laravel development server
- Queue listener
- Laravel log viewer
- Vite dev server

If you prefer to run services separately:

```bash
php artisan serve
npm run dev
php artisan queue:work
```

## Seeded Accounts

The database seeders create the following default users:

| Role | Email | Password |
| --- | --- | --- |
| Super Admin | `superadmin@admin.com` | `password` |
| Merchant | `User1@merchant.com` | `password` |
| Merchant | `User2@merchant.com` | `password` |

Change these credentials outside local development.

## Mail and Queue Setup

Several mailables implement queued delivery, so email notifications depend on both mail configuration and a running queue worker.

By default, `.env.example` uses the `log` mailer, which is safe for local development. To use SMTP, update the mail settings in `.env` with your own credentials. Example:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="Tun Rice Milling"
```

Then run a worker:

```bash
php artisan queue:work
```

Do not commit real mail credentials to the repository.

## Useful Commands

```bash
composer run dev
composer test
php artisan migrate --seed
php artisan queue:work
npm run build
```

## Testing

Run the test suite with:

```bash
composer test
```

## Project Structure

Important application areas:

- `app/Services` contains business logic for appointments, drying, milling, paddy handling, and milling prediction.
- `app/Mail` contains queued notification mailables.
- `routes/web.php` defines the admin and merchant web flows.
- `database/seeders` contains role, permission, and default account seed data.
- `resources/views` contains the Blade views for the public site, admin portal, and merchant portal.

## Notes

- Role-based access control is enforced with permissions such as `admin-dashboard` and `user-dashboard`.
- PDF reports are generated with `barryvdh/laravel-dompdf`.
- The milling predictor logic lives in `app/Services/MillingPredictor.php`.

