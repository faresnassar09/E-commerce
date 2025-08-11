<h1 align="center">🛒 E-Commerce Platform</h1>

<p align="center">
  Laravel-based multi-vendor e-commerce solution with subscription system, seller panel, and modular product management.
</p>

---

## 🚀 Overview

This is a **full-featured backend e-commerce platform** built with **Laravel**, designed to support a marketplace where multiple sellers can register, manage their products, and receive orders from buyers. The system is scalable, secure, and developer-friendly, with clean architecture and flexible components.

---

## 🧩 Features

- 🧑‍💼 **Multi-vendor system** with individual seller panels
- 📦 **Product management**: Create, edit, delete, and manage inventory
- 💳 **Subscription system**: Sellers must subscribe to add products *(Laravel Cashier integrated)*
- 📥 **Order tracking**: Full order lifecycle from cart to delivery
- 📍 **Location-based filtering**: Users can browse sellers by city, area, and street
- 📊 **Admin dashboard** via Filament Panel
- 📸 Product gallery with support for multiple images
- 🔐 **Authentication** with Laravel Breeze
- 📡 Built using **Livewire** for dynamic UX
- 🌐 *Localization* support English And Arabic 
- 📁 File hosting & management for product documents
- ⚙️ Role-based access with Policies & Gates
- ✅ Clean, structured codebase with logging & exception handling

---

## 🛠️ Tech Stack

- **Backend**: Laravel 10
- **Frontend**: Blade, TailwindCSS, Livewire
- **Admin Panel**: FilamentPHP
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Payment & Subscriptions**: Laravel Cashier
- **PDF Generation**: mPDF
- **Storage**: Laravel File Storage (Local/File Hosting)

---

## 📦 Requirements

- PHP >= 8.1
- Composer
- MySQL
- Node.js + NPM (for asset compilation)
- Laravel CLI

---

## 🔧 Setup Instructions

git clone https://github.com/faresnassar09/E-commerce.git

cd E-commerce

composer install

#init Environment
cp .env.example .env

php artisan key:generate

#migrate tables and columns
php artisan migrate

# 5. Start the server
php artisan serve
