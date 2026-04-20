# Lumora Commerce

Portfolio-ready full-stack Laravel e-commerce application with customer storefront, admin panel, cart and checkout flow, Midtrans Sandbox payment integration, inventory tracking, and automated test coverage.

## Project Summary

**Lumora Commerce** is a production-style e-commerce platform built to showcase how a Laravel application can be structured beyond CRUD.  
The project includes catalog management, customer ordering flow, payment callback handling, stock tracking, admin operations, and testing for core business scenarios.

### Short Description for CV / LinkedIn / Portfolio

Built a full-stack e-commerce platform using Laravel 12, Blade, Tailwind CSS, MySQL, and Midtrans Sandbox with customer storefront, admin dashboard, cart and checkout flow, payment callback handling, inventory logging, role-based authorization, and automated test coverage for core business processes.

## Why This Project Stands Out

- Production-like structure with separated `frontend`, `customer`, `admin`, and `auth` route files
- Role-based access control for admin and customer flows
- Database-backed cart, checkout, order, payment, and inventory lifecycle
- Midtrans Sandbox integration with webhook-based payment synchronization
- Inventory movement logging for checkout, payment success, release, restock, and manual stock sync
- Clean Blade + Tailwind UI for storefront and admin experiences
- Reusable services for cart, checkout, payment, inventory, and customer order access
- Automated tests covering core business flows and restrictions

## Core Features

### Customer Features

- Authentication with register, login, logout, password reset, and email verification
- Product catalog with:
  - search by product name
  - category filtering
  - sorting
  - pagination
  - stock visibility
  - sold-out badge
- Product detail page with related products
- Database-backed cart management
  - add to cart
  - update quantity
  - remove item
  - stock-aware validation
- Checkout flow with shipping information snapshot
- Order history and order detail pages
- Payment resume flow for pending Midtrans payments

### Admin Features

- Dashboard overview:
  - total products
  - total orders
  - total revenue
  - low stock products
- Category CRUD
- Product CRUD
- Multiple product image upload
- Stock management
- Order listing and order detail
- Order status update
- Payment visibility from admin order detail
- Inventory log history with restock and stock sync actions

### Payment & Inventory Features

- Midtrans Snap Sandbox integration
- Payment record persistence in database
- Webhook notification handler
- Order and payment status synchronization
- Inventory logs for:
  - initial stock
  - restock
  - adjustment
  - reserved stock
  - released stock
  - deducted/finalized stock

## Tech Stack

### Backend

- PHP 8.2+
- Laravel 12
- Eloquent ORM
- Form Request validation
- Service-oriented business logic

### Frontend

- Blade
- Tailwind CSS 4
- Vite
- Alpine.js

### Database & Infrastructure

- MySQL
- Laravel migrations
- Laravel seeders
- Queue-ready architecture

### Payment Gateway

- Midtrans PHP SDK
- Midtrans Snap Sandbox

### Quality & Tooling

- PHPUnit 11
- Laravel Breeze
- Laravel Pint
- Faker
- Mockery

## Architecture Overview

The project follows a layered Laravel approach so the code stays readable and maintainable as features grow.

### Main Layers

- `Controllers`
  Handle HTTP input/output and keep request flow thin
- `Form Requests`
  Centralize validation and request authorization
- `Services`
  Hold business rules for cart, checkout, payment, inventory, product admin flow, and customer order access
- `Models`
  Represent domain entities such as products, orders, payments, carts, and inventory logs
- `Blade Views`
  Render customer storefront and admin panel UI

### Important Service Classes

- `CartService`
  Manages active cart creation, quantity rules, totals, and stock-aware cart updates
- `CheckoutService`
  Creates orders transactionally from cart data
- `MidtransService`
  Creates Snap payment sessions and handles webhook synchronization
- `InventoryService`
  Centralizes stock changes and inventory logging
- `CustomerOrderService`
  Centralizes secure access to customer-owned orders

## Project Structure

```text
E-Commerce/
+-- app/
|   +-- Http/
|   |   +-- Controllers/
|   |   |   +-- Admin/
|   |   |   +-- Auth/
|   |   |   +-- Frontend/
|   |   |   `-- Payments/
|   |   +-- Middleware/
|   |   `-- Requests/
|   |       +-- Admin/
|   |       +-- Auth/
|   |       `-- Frontend/
|   +-- Models/
|   +-- Services/
|   +-- Support/
|   `-- View/
+-- bootstrap/
+-- config/
+-- database/
|   +-- factories/
|   +-- migrations/
|   `-- seeders/
+-- public/
+-- resources/
|   +-- css/
|   +-- js/
|   `-- views/
|       +-- admin/
|       +-- auth/
|       +-- components/
|       +-- frontend/
|       +-- layouts/
|       `-- vendor/
+-- routes/
|   +-- admin.php
|   +-- auth.php
|   +-- customer.php
|   +-- frontend.php
|   `-- web.php
+-- storage/
+-- tests/
|   +-- Concerns/
|   +-- Feature/
|   `-- Unit/
+-- composer.json
+-- package.json
`-- README.md
```

## Installation Guide

### 1. Clone Repository

```bash
git clone <your-repository-url>
cd E-Commerce
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Create Environment File

```bash
cp .env.example .env
```

If you are on Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Configure Database

Edit `.env` and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_commerce_platform
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Seed Initial Data

```bash
php artisan db:seed
```

### 8. Link Storage for Uploaded Images

```bash
php artisan storage:link
```

### 9. Run Frontend Build

Development:

```bash
npm run dev
```

Production build:

```bash
npm run build
```

### 10. Start Development Server

```bash
php artisan serve
```

## Environment Setup Guide

Use `.env.example` as the main reference. The most important sections are:

### Application

```env
APP_NAME="Lumora Commerce"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id
```

### Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e_commerce_platform
DB_USERNAME=root
DB_PASSWORD=
```

### Session / Cache / Queue

```env
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### Mail

```env
MAIL_MAILER=log
```

This is enough for local development if you do not need real email delivery yet.

## Database Seeding Guide

The project already includes seeders for initial admin and catalog data:

- `AdminUserSeeder`
- `CategorySeeder`
- `ProductSeeder`
- `ProductImageSeeder`

Run:

```bash
php artisan db:seed
```

Or refresh everything from scratch:

```bash
php artisan migrate:fresh --seed
```

### Seeded Data Includes

- 1 admin account
- parent and child categories
- sample products
- sample product visuals

## Midtrans Sandbox Setup Guide

This project is configured for **Midtrans Sandbox**.

### 1. Create Midtrans Sandbox Account

Sign in or register at:

- https://dashboard.midtrans.com/

### 2. Get Sandbox Credentials

From the Midtrans dashboard, collect:

- Merchant ID
- Server Key
- Client Key

### 3. Fill Environment Variables

```env
MIDTRANS_MERCHANT_ID=your_sandbox_merchant_id
MIDTRANS_SERVER_KEY=your_sandbox_server_key
MIDTRANS_CLIENT_KEY=your_sandbox_client_key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### 4. Webhook Notification URL

Use this route for Midtrans notification:

```text
/payments/midtrans/notification
```

Example local tunnel URL:

```text
https://your-ngrok-url.ngrok-free.app/payments/midtrans/notification
```

### 5. Payment Flow Summary

- Customer checkout creates order and order items
- System prepares Midtrans Snap session
- Customer pays through Snap popup
- Midtrans sends webhook notification
- Application updates:
  - payment status
  - order status
  - inventory state if needed

## Demo Accounts

### Admin Account

Created automatically by seeder:

```text
Email    : admin@ecommerce.test
Password : password
```

### Customer Account

There is no fixed seeded customer account by default.  
For demo purposes, create one using the register page:

```text
/register
```

This keeps the customer flow realistic for portfolio walkthroughs.

## Testing

Automated tests are included for critical business flows.

Run all tests:

```bash
php artisan test
```

Run a specific test file:

```bash
php artisan test tests/Feature/CheckoutFlowTest.php
php artisan test tests/Feature/MidtransWebhookTest.php
php artisan test tests/Unit/InventoryServiceTest.php
```

### Current Test Coverage Focus

- auth login/register flow
- product listing
- add to cart
- checkout and order creation
- payment callback handling
- admin access restriction
- stock update logic

## Screenshot Placeholder

Replace this section with actual screenshots before publishing to GitHub portfolio.

| Screen | Placeholder |
| --- | --- |
| Storefront Home | Add screenshot here |
| Product Listing | Add screenshot here |
| Product Detail | Add screenshot here |
| Cart | Add screenshot here |
| Checkout | Add screenshot here |
| Order History | Add screenshot here |
| Admin Dashboard | Add screenshot here |
| Product Management | Add screenshot here |
| Order Detail | Add screenshot here |
| Inventory Logs | Add screenshot here |

Suggested folder:

```text
docs/screenshots/
```

Suggested filenames:

```text
docs/screenshots/storefront-home.png
docs/screenshots/product-listing.png
docs/screenshots/product-detail.png
docs/screenshots/cart.png
docs/screenshots/checkout.png
docs/screenshots/order-history.png
docs/screenshots/admin-dashboard.png
docs/screenshots/admin-products.png
docs/screenshots/admin-order-detail.png
docs/screenshots/admin-inventory.png
```

## Suggested Deployment

### Good Options

- VPS with Nginx + PHP-FPM + MySQL
- Laravel Forge
- Ploi
- Shared hosting with proper PHP 8.2 support
- Dockerized VPS deployment

### Deployment Checklist

- set `APP_ENV=production`
- set `APP_DEBUG=false`
- configure real database credentials
- configure real `APP_URL`
- set Midtrans production/sandbox config correctly
- run:

```bash
php artisan migrate --force
php artisan db:seed --force
php artisan optimize
npm run build
php artisan storage:link
```

### Optional Production Improvements

- move queue to Redis + queue worker
- configure Horizon
- configure real mail provider
- add log monitoring
- add backup strategy
- add S3-compatible file storage

## Future Improvements

- customer review and rating system
- coupon and discount engine
- shipping API integration
- invoice PDF generation
- dashboard analytics and charts
- product variants and attributes
- wishlist and recently viewed products
- order cancellation flow from customer side
- refund workflow from admin side
- stronger policy-based authorization
- CI pipeline for test + lint + build

## Presentation Talking Points

Use these points when presenting the project in interviews, demos, or portfolio reviews.

- I built this project as a production-style Laravel e-commerce application, not just a CRUD demo.
- I separated route files and controllers by context: frontend, customer, admin, auth, and payment webhook.
- Business logic is moved into service classes like `CartService`, `CheckoutService`, `MidtransService`, and `InventoryService`.
- The payment flow uses Midtrans Snap Sandbox and webhook synchronization, so payment status is not trusted from the frontend alone.
- Inventory updates are logged and traceable, which makes the project closer to a real transactional commerce system.
- I implemented role-based access restriction for admin and customer flows.
- I added automated tests for auth, cart, checkout, payment callback, admin restriction, and stock logic.
- The UI is intentionally split into customer storefront and admin workspace to show both product-facing and operation-facing interfaces.

## Portfolio Highlights

- End-to-end e-commerce flow from product discovery to payment callback
- Admin panel with real operational features, not only dashboard cards
- Inventory-aware checkout and payment synchronization
- Security-minded validation and authorization improvements
- Test suite that covers core business scenarios

## License

This project is intended for learning, portfolio, and demonstration purposes.
