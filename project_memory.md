# Project Memory: JAFAPP

## System Configuration
- PHP Version: 8.4.11
- Laravel Version: 13.12.0
- Database: MySQL 8.0.30 (Laragon)
- Database Name: jafapp
- Node.js: v22.14.0
- NPM: v10.9.2
- Third-Party APIs: Midtrans Payment Gateway (Sandbox)

## Composer Packages
- `midtrans/midtrans-php` v2.6.2
- `barryvdh/laravel-dompdf` v3.1.2
- `maatwebsite/excel` v1.1.5

## Database Schema (Current Status)
- Tables implemented: users (modified), categories, products, orders, order_items, custom_orders, payments, production_logs, cache, jobs, sessions
- Structural changes made:
  - users: Added role, phone, address, is_active, is_guest, activation_token, activation_token_expires_at
  - orders: Has shipping_cost, subtotal, total_amount columns (for manual shipping cost by admin)
  - All indexes from PRD Section 8.3 applied

## Eloquent Models
- User (modified default) — with role helpers (isAdmin, isSuperAdmin, isGuestAccount, isActiveAccount, hasAdminAccess)
- Category — auto-slug from name
- Product — auto-slug, active scope, first_image accessor, images JSON cast
- Order — status constants, production sequence constants, status label accessor (Bahasa Indonesia)
- OrderItem — only created_at, snapshot price/subtotal
- CustomOrder — status constants, ref_images JSON, status label accessor
- Payment — Midtrans fields, raw_response JSON, status helpers
- ProductionLog — strict sequential status validation (isValidTransition), status label accessor

## Design & Theme Decisions
- Color Tokens: Primary Brown #6B3A2A, Light Brown #A0522D, Cream #F5F0E8, Off-White #FAFAF7, Dark Green #2D4A3E
- Text Primary: #1A1A1A, Text Secondary: #6B7280, Border: #E5E0D8
- Typography: Playfair Display (headings), Inter (body/forms)
- Component conventions: Blade Components, TailwindCSS classes

## API Integrations
- Midtrans: config/midtrans.php configured, .env variables set (sandbox keys)
- Webhook: POST /api/midtrans/callback — excluded from CSRF in bootstrap/app.php

## Middleware
- RoleMiddleware: registered as alias 'role' in bootstrap/app.php
- CSRF exclusion for 'api/midtrans/callback'

## Seeded Data
- SuperAdmin: superadmin@jafapp.com / superadmin123
- Admin: admin@jafapp.com / admin123
- Categories: 7 (Kursi, Meja, Lemari, Tempat Tidur, Rak, Pintu & Jendela, Aksesoris)
- Products: 9 dummy products with realistic Indonesian descriptions

## Git
- Initialized with branches: main, develop (currently on develop)
- Initial commit: "Phase 1: Initial Laravel 13 setup with JAFAPP database schema, models, RBAC middleware, Midtrans config, and seeders"

## Key Decisions
- Cart: Session-based (no database table), to be implemented in Phase 2/3
- Shipping cost: Manual input field by admin in orders (shipping_cost column)
- Product photos: Will use real photos from client

## Development Log
- [2026-05-28] - Action: Initialized project memory
- [2026-05-28] - Action: Created Laravel 13 project, installed all dependencies
- [2026-05-28] - Action: Created 8 migration files, ran all migrations successfully
- [2026-05-28] - Action: Created 8 Eloquent models with relationships and helpers
- [2026-05-28] - Action: Created RoleMiddleware, registered in bootstrap/app.php
- [2026-05-28] - Action: Created config/midtrans.php, set .env variables
- [2026-05-28] - Action: Created CategorySeeder (7 categories), ProductSeeder (9 products), SuperAdminSeeder (2 accounts)
- [2026-05-28] - Action: Ran all seeders successfully
- [2026-05-28] - Action: Created storage:link
- [2026-05-28] - Action: Git init, initial commit, created main & develop branches
- [2026-05-28] - Phase 1 COMPLETED ✅
