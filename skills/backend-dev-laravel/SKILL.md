---
name: backend-dev-laravel
description: Rules and guidelines for secure, standard-compliant Laravel 11 & PHP 8.3 development, detailing database design, validation, RBAC, and queue architecture.
---

# Backend Laravel Development Skill

## Overview
This skill outlines standard development procedures for building the PHP 8.3/Laravel 11 backend of JAFAPP. It enforces PSR-12 styling, MVC-service patterns, input security, migrations, and performance.

## Backend Guidelines

### 1. Code Standards & Architecture
- Enforce **strict types** at the top of every PHP file:
  ```php
  declare(strict_types=1);
  ```
- Follow the **Service Layer Pattern** to keep Controllers light. Put complex business operations (such as checkout handling and payment processing) in dedicated service classes (e.g., `app/Services/MidtransService.php`, `app/Services/OrderService.php`).
- Business models must utilize **Eloquent relationships** with strict constraints (e.g., cascade/set null rules on foreign keys).

### 2. Database Migrations & Seeding
- Perform all database schema changes strictly through Laravel Migrations. Do not execute manual queries on the database.
- Use indexes on columns that are frequently filtered, searched, or used in relationships (`user_id`, `order_number`, `status`, `created_at`).
- Provide Seeders to pre-populate product categories and initial catalog products for sandbox testing.

### 3. Secure Input Validation
- Always use **Form Requests** (`php artisan make:request`) to separate validation from Controller code.
- Prevent SQL Injection by using Eloquent or Query Builder parameters. Never concatenate raw user input into database queries.
- Sanitize and validate file uploads: enforce JPG, PNG, or PDF formats, limit file size to 2MB (or 5MB for custom order designs), and validate file extensions.

### 4. Role-Based Access Control (RBAC)
- Define roles: `customer`, `admin`, `superadmin`.
- Guard admin and owner routes using custom middleware: `auth` + `role:admin,superadmin`.
- Restrict sensitive actions (like adding administrators or reading system audits) exclusively to `superadmin`.

### 5. Asynchronous Queues & Emails
- Process automated emails (Order Confirmation, Credentials, Activations) using **Laravel Queue** (configured to run on supervisor or database driver). This prevents blocking the HTTP request thread during checkout.
- Handle queue retries and failed jobs using Laravel's native queue features.

## Common Mistakes
- **Fat Controllers**: Placing SQL queries and notification logic inside the Controller instead of using Eloquent relationships, Form Requests, and Service classes.
- **Missing CSRF tokens**: Forgetting `@csrf` on Blade forms.
- **Ignoring indexes**: Querying lists of orders or production logs without indexing the search keys, causing high latency.
