# WEIN — Order Management System

A simple, clean Laravel 12 order management system for managing SHEIN group purchases, customer orders, instant products, delivery areas, and notifications. Supports Arabic and English.

## Quick Start

```bash
# 1. Copy environment file and configure your SQL Server credentials
cp .env.example .env

# 2. Edit .env — set DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
nano .env

# 3. Install dependencies
composer install

# 4. Generate app key
php artisan key:generate

# 5. Run migrations
php artisan migrate

# 6. Seed initial data (admin + sample data)
php artisan db:seed

# 7. Start the development server
php artisan serve
```

Then open **http://localhost:8000**.

---

## Default Admin Credentials

| Field    | Value           |
|----------|-----------------|
| Email    | admin@wein.com  |
| Password | password        |

Admin panel is at **/admin/login**

---

## Environment Requirements

- **PHP** 8.3+
- **SQL Server** with `sqlsrv` and `pdo_sqlsrv` PHP extensions
- **Composer** 2.x
- Works on: **Laragon**, **XAMPP** (with SQL Server driver), **VPS**, **Shared Hosting**

### SQL Server PHP Extensions (Windows — Laragon)

Download the drivers from: https://docs.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server

Add to `php.ini`:
```ini
extension=php_sqlsrv_83_ts_x64.dll
extension=php_pdo_sqlsrv_83_ts_x64.dll
```

---

## Modules

| Module | Description |
|--------|-------------|
| **Admin Auth** | Secure login/logout for admin panel |
| **Main Orders** | Create and manage SHEIN bulk orders with status tracking |
| **Customer Orders** | Customers add orders with password; can view/edit/delete |
| **Notifications** | Admin posts notifications per order; customers see them |
| **Delivery Areas** | Manage cities with delivery prices; auto-calculated on selection |
| **Instant Products** | Admin publishes immediately available products |
| **Reservations** | Customers reserve instant products with quantity tracking |
| **Settings** | Language (Arabic/English), theme (light/dark), view mode |

---

## Status Flow

```
Open → Sorting → Sent → Shipping → Delivery → Delivered
         ↓
       Closed
```

Customers can **only modify their orders** when the status is **Open**.

---

## Folder Structure

```
app/
  Http/
    Controllers/
      Admin/       — Admin controllers
      Public/      — Public-facing controllers
    Middleware/    — AdminAuthenticated, SetLocale
  Models/          — Eloquent models

resources/
  views/
    layouts/       — admin.blade.php, public.blade.php
    admin/         — All admin views
    public/        — All public views
  css/app.css      — Full CSS with light/dark theme + RTL
  js/app.js        — Modals, delivery price lookup, view toggle

lang/
  en/messages.php  — English strings
  ar/messages.php  — Arabic strings

database/
  migrations/      — 7 migration files
  seeders/         — Admin, delivery areas, sample order

routes/web.php     — All routes
```

---

## Customer Order Access

There is **no registration**. Each customer order has its own password set at creation time.

To access their order later, customers enter:
- Their **Order ID** (shown after creation)
- **Phone number**
- **Password**

---

## Notes

- No external packages — pure Laravel + vanilla JS/CSS
- No queues, no events, no over-engineering
- RTL layout auto-applied for Arabic
- Light/Dark theme stored in cookies
- Card/List view preference stored in cookies
