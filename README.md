# Laravel Deposit System with Duitku Integration

This is a Laravel-based deposit system built as part of a backend skill assessment.  
This system demonstrates a **multi-level user platform** with **deposit and cashback functionality**, integrated with the **Duitku payment gateway**, and uses **Bootstrap** for the frontend.

## 🚀 Features

- 🔐 **User Roles**:
  - Admin
  - Supervisor
  - Regular User

- 💰 **Deposit System** (via Duitku payment gateway):
  - **TIER-1**: Min. Rp 5,000,000 → Cashback 5%
  - **TIER-2**: Min. Rp 10,000,000 → Cashback 12%
  - **TIER-3**: Min. Rp 15,000,000 → Cashback 20%

- 🛍️ **Client Area**:
  - Users can deposit via Duitku
  - Cashback is automatically added to balance
  - Balance can be used to **purchase dummy products**

- 📦 **Products**:
  - Dummy product list for testing purchases

- 🛠️ **Planned Features**:
  - 📊 Admin Panel:
    - View all deposit transactions
    - Manage users and roles
    - Monitor deposit activity

- 🎨 **Frontend**: Built with Bootstrap 5

## 🔧 Installation

```bash
# Clone the project
git clone https://github.com/tamzidan/laravel-deposit-system.git
cd laravel-deposit-system

# Install dependencies
composer install
npm install && npm run dev

# Copy and configure environment
cp .env.example .env
php artisan key:generate

# Set your DB credentials in `.env`
php artisan migrate --seed

# Run the server
php artisan serve