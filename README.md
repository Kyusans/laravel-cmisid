# 📊 Information System Management System (Laravel)

A Laravel-based Information System Management System designed to manage and organize system-related data efficiently.

---

## 🚀 Installation Guide

Follow these steps to run the project locally:

### 1. Clone the Repository
```bash
git clone https://github.com/Kyusans/laravel-ISMS.git
cd laravel-ISMS
```

### 2. Install Dependencies
Install PHP and JavaScript dependencies:
```bash
composer install
npm install
```

### 3. Setup Environment File
Copy the environment file and generate the application key:
```bash
cp .env.example .env
php artisan key:generate
```

Then configure your database in the `.env` file.

### 4. Run Migrations and Seeders
```bash
php artisan migrate --seed
```

### 5. Build Frontend Assets
```bash
npm run dev
```

### 6. Start the Development Server
```bash
php artisan serve
```

---

## 🔐 Default Admin Account

Use the following credentials to log in:

- **Email:** admin@gmail.com  
- **Password:** admin 

---

## 📌 Notes

- Make sure your database is properly configured before running migrations.
- If you encounter issues, try clearing the cache:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 📄 License

This project is open-source and available for use.