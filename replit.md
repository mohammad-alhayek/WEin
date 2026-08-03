# WEIN — Order Management System

A Laravel 12 order management system for managing SHEIN group purchases, customer orders, instant products, delivery areas, and notifications. Supports Arabic and English (RTL).

## Stack

- **PHP 8.3+** / Laravel 12
- **Database**: SQL Server (configured in `.env` — swap to SQLite/MySQL/PostgreSQL to run on Replit)
- **Frontend**: Vanilla JS + CSS (no npm build step needed; compiled assets are in `public/`)
- **No external packages** — pure Laravel

## Project Structure

```
app/Http/Controllers/
  Admin/     — Admin panel controllers (auth, orders, customers, delivery, notifications)
  Public/    — Public-facing controllers (order lookup, instant products, settings)
app/Models/  — Eloquent models (Admin, Order, CustomerOrder, DeliveryArea, InstantOrder, …)

resources/views/
  layouts/   — admin.blade.php, public.blade.php
  admin/     — Admin panel views
  public/    — Customer-facing views

lang/
  en/messages.php
  ar/messages.php

database/
  migrations/   — 7 migration files
  seeders/      — Admin (admin@wein.com / password), delivery areas, sample order

routes/web.php  — All routes
```

## Key Routes

| Path | Description |
|------|-------------|
| `/` | Public order lookup / home |
| `/admin/login` | Admin login |
| `/admin/dashboard` | Admin dashboard |

## Default Admin Credentials

| Field | Value |
|-------|-------|
| Email | admin@wein.com |
| Password | password |

## Order Status Flow

```
Open → Sorting → Sent → Shipping → Delivery → Delivered
         ↓
       Closed
```

Customers can only modify their orders when status is **Open**.

## User Preferences

- Keep the existing Laravel structure — do not restructure or migrate to another framework.
- No build step for frontend assets; `public/css/app.css` and `public/js/app.js` are the compiled outputs.
