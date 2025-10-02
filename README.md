# Tdevs Laravel Authentication & Subscription System

A comprehensive Laravel-based authentication and subscription management system with email verification, OTP login, payment gateway integration and without package using.

## Table of Contents

- [Features](#features)
- [System Requirements](#system-requirements)
- [Installation Guide](#installation-guide)
- [API Documentation](#api-documentation)

## Features

### User Module
- User registration with email verification
- OTP-based secure login system
- Email notifications via Mailtrap
- Tiered subscription plans (Basic, Gold, Diamond)
- PayPal and Stripe payment integration (sandbox mode)
- User dashboard with subscription-based data access
- Automated subscription expiration management via cron jobs
- Secure logout functionality

### Admin Module
- Default credential-based admin authentication
- User management dashboard
- Subscription plan creation and management
- Payment gateway configuration (PayPal/Stripe)
- Admin-specific secure logout

### API Module
- RESTful authentication endpoints
- Subscription plans API
- Subscribe API with payment processing
- Token-based API authentication

## System Requirements

- PHP >= 8.2
- LARAVEL >= 12
- Composer >= 2.0
- MySQL >= 8.0 

## Installation Guide

1. Clone the repository:

   ```bash
    git clone https://github.com/sujonmia019/tdev-task

2. Navigate to the project directory

    ```bash
    cd tdev-task

3. Install dependencies using Composer

    ```bash
    composer install

4. Node js packase install

    ```bash
    npm install

5. Copy the .env.example file to .env

    ```bash
    cp .env.example .env

6. Generate the application key

    ```bash
    php artisan key:generate

7. Set up your database connection in the .env file

    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```
    ```bash
    MAIL_MAILER=
    MAIL_HOST=
    MAIL_PORT=
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=
    ```

8. Run the migrations with user seeding

    ```bash
    php artisan migrate:fresh --seed

9. Demo Access
    ```php
    Email: admin@example.com
    Pass: 12345678

    Email: user@example.com
    Pass: 12345678
    ```

10. Run the migrations without seeding

    ```bash
    php artisan migrate

11. Start the development server

    ```bash
    php artisan serve

#### Open Postman
Download or browser login and install Postman if you don’t already have it.

## API Endpoints

### Public Endpoints
| Method | Endpoint        | Description              |
|--------|-----------------|--------------------------|
| POST   | `/api/register` | Register a new user  |
| POST   | `/api/login`    | Login (User/Admin)   |

---

### Endpoints (Authenticated)
| Method | Endpoint                    | Description                     |
|--------|-----------------------------|---------------------------------|
| GET    | `/api/v1/plans`             | List all plans                  |
| POST   | `/api/v1/subscribe/{id}/pay`| Subscribe a plan                |
| GET    | `/api/v1/payment/success`   | Success payment process         |
| GET    | `/api/v1/payment/cancel`    | Cancel payment process          |

---
