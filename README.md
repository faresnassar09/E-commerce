# Grocery E-commerce (Laravel)

Multi-vendor e-commerce platform (Users, Sellers, Admins) with persistent cart, multi-store, returns, subscriptions (Stripe), tickets, notifications, and Arabic/English localization.

## Features
- Roles & Policies: Users / Sellers / Admins
- Persistent Cart (DB-based), multi addresses per user
- Full order lifecycle: open / delivered / returned + return reason & email notifications
- Sellers: multi-store, multi-image products, stats dashboard
- Admin: tickets (chat-like) with attachments, global stats
- Subscriptions via Stripe + middleware gating
- Categories & search
- Notifications & logging
- Livewire for interactive UI
- Localization : English & Arabic
- Clean architecture: Services, Policies, Facades

## Tech Stack
Laravel, Livewire, MySQL/PostgreSQL, Filament, Mail, Stripe

## Screenshots
See `/docs/screenshots/` for flows (cart, checkout, seller dashboard, tickets, etc.)

## Getting Started
### Requirements
- PHP 8.2+, Composer
- MySQL

### Installationb & Using
```bash
cp .env.example .env
# fill DB_*, MAIL_*, STRIPE_* keys
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve

Ready-to-use emails

User : user@test.com
Seller : seller@test.com
Admin : admin@test.com
Admin Link : https://lightgray-chinchilla-755244.hostingersite.com/admin/login

