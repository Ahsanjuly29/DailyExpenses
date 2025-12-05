# 💸 DailyExpenseManager

A simple **CRUD application** to manage your daily expenses. Built with **Laravel**, this project helps you track, categorize, and report your personal expenses effortlessly.

---

## 🚀 Features

* User Authentication (Register, Login, Password Reset, Email Verification)
* CRUD operations for expenses
* Expense categories: **Food, Transport, Shopping, Others**
* Dashboard with monthly summary and remaining budget
* Expense reports
* RESTful API endpoints for integration
* Local environment auto-setup for demo data

---

## 🖥️ Screenshots

| Dashboard                       | Add Expense                       | Expense List                       | Expense Report                       |
| ------------------------------- | --------------------------------- | ---------------------------------- | ------------------------------------ |
| ![Dashboard](screenshots/1.png) | ![Add Expense](screenshots/2.png) | ![Expense List](screenshots/3.png) | ![Expense Report](screenshots/4.png) |

---

## ⚡ Installation

1. Clone the repository:

```bash
git clone https://github.com/Ahsanjuly29/DailyExpenses.git
cd DailyExpenseManager
```

2. Install dependencies:

```bash
composer install
npm install && npm run dev
```

3. Set up environment variables:

```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations:

```bash
php artisan migrate
```

5. Start the development server:

```bash
php artisan serve
```

---

## 📝 Usage

1. Register or log in.
2. Access the dashboard to see your monthly targets and expense summary.
3. Add, edit, or delete expenses under different categories.
4. Generate reports to track your spending trends.

---

## 🔗 API Endpoints

* `/api-company-data` → Company CRUD
* `/api-investment-data` → Investment CRUD
* `/api-investment-log-data` → Investment Logs
* `/api-job-earning-data` → Job Earnings
* Authenticated via **Laravel Sanctum**

---

## 👨‍💻 Tech Stack

* PHP 8.x
* Laravel 12
* MySQL / SQLite
* Blade Templates
* Tailwind CSS (optional)

---

## 📂 Folder Structure(Example)

```
app/
├─ Http/
│  ├─ Controllers/
│  │  ├─ ExpenseController.php
│  │  └─ ...
├─ Models/
│  └─ Expense.php
routes/
├─ web.php
├─ api.php
├─ auth.php
resources/
├─ views/
public/
screenshots/
├─ 1.png
├─ 2.png
├─ 3.png
├─ 4.png
```

---

## ✅ License

open for all
