# 🎓 Online Examination & Student Management Portal

This project is a web-based **Online Examination and Student Management Portal** developed using **Laravel 11** with **Laravel Breeze** for authentication.
The system supports **Lecturer** and **Student** roles, enabling secure exam creation, class & subject management, and controlled student access to exams with time limits.

---

## 📌 Features Overview

### Core Features

* **Role-Based Access**

  * Lecturer
  * Student
* **Authentication**

  * Secure login & logout using Laravel Breeze
* **Exam Management**

  * Multiple Choice Questions (MCQ)
  * Open Text Questions
* **Class Management**

  * Students grouped into classes
* **Subject Management**

  * Each class can have multiple subjects
* **Access Control**

  * Students can only access exams assigned to their class
* **Time-Limited Exams**

  * Exams have configurable duration (e.g. 15 minutes)
* **Additional Features**

  * Exam availability window (start & end time)
  * Auto-submit when time expires
  * Exam attempt tracking
  * Lecturer dashboard for exam monitoring

---

## 🛠️ Tech Stack

* **Framework:** Laravel 11
* **Authentication:** Laravel Breeze
* **Frontend:** Blade, Bootstrap
* **Backend:** PHP 8.2+
* **Database:** MySQL (can be replaced with PostgreSQL / SQLite)
* **Version Control:** Git & GitHub

---

## ⚙️ Installation Guide

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/hamzah014/student-portal.git
cd student-portal
```

---

### 2️⃣ Install Dependencies

Make sure **Composer** and **Node.js** are installed.

```bash
composer install
npm install
npm run build
```

---

### 3️⃣ Environment Setup

Copy the environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

### 4️⃣ Database Configuration

Update your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=studentportal
DB_USERNAME=root
DB_PASSWORD=
```

Create the database manually (e.g. using phpMyAdmin or MySQL CLI).

---

### 5️⃣ Run Migrations & Seeders

```bash
php artisan migrate
php artisan db:seed
```

> Seeders will create default roles (Lecturer & Student) and sample data if provided.

---

### 6️⃣ Run the Application

```bash
php artisan serve
```

Access the system at:

```
http://127.0.0.1:8000
```

---

## 📎 System Usage References

> **Google Drive Link:**
> 👉 [https://drive.google.com/drive/folders/1kBr0x83hAAXI1IF5Snlw25S4omlAqQAP?usp=sharing](https://drive.google.com/drive/folders/1kBr0x83hAAXI1IF5Snlw25S4omlAqQAP?usp=sharing)

---

## 📄 License

This project is developed **for assessment purposes**.
You are free to modify and extend it.

---

## 👤 Author

**Muhammad Hamzah Bin Mohd Jamal**
Laravel Full Stack Developer
📍 Malaysia
