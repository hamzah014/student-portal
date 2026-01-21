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

## 📂 Project Structure (Simplified)

```
├── app/
│   ├── Models/
│   ├── Http/Controllers/
│   ├── Policies/
├── database/
│   ├── migrations/
│   ├── seeders/
├── resources/
│   ├── views/
│   ├── css/
│   ├── js/
├── routes/
│   ├── web.php
├── public/
├── README.md
```

---

## ⚙️ Installation Guide

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/your-username/online-exam-portal.git
cd online-exam-portal
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
DB_DATABASE=online_exam
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

## 🔐 Authentication & Roles

### Lecturer

* Create and manage exams
* Add MCQ and open-text questions
* Assign exams to classes
* Set exam duration & availability
* View student submissions

### Student

* Login securely
* View assigned exams only
* Take exams within time limit
* Submit answers

---

## 📝 Exam Workflow

1. **Lecturer**

   * Creates a class
   * Adds subjects to the class
   * Creates an exam for a subject
   * Adds questions (MCQ / Text)
   * Sets time limit and availability

2. **Student**

   * Logs in
   * Sees available exams for their class
   * Starts exam (timer begins)
   * Submits answers before time expires

---

## ⏱️ Time Limit Handling

* Exam timer starts once the student begins the exam
* Auto-submission occurs when time expires
* Students cannot reattempt completed exams

---

## 🔒 Access Control

* Middleware ensures:

  * Only lecturers can manage exams
  * Only students can take exams
* Policy-based authorization for exam access
* Students can only see exams assigned to their class

---

## 🧪 Testing (Optional)

```bash
php artisan test
```

---

## 🚀 Deployment Notes

* Ensure `APP_ENV=production`
* Run:

  ```bash
  php artisan optimize
  php artisan migrate --force
  ```
* Set proper file permissions for:

  * `storage/`
  * `bootstrap/cache/`

---

## 📎 GitHub Repository

> **Public Repository Link:**
> 👉 [https://github.com/your-username/online-exam-portal](https://github.com/your-username/online-exam-portal)

---

## 📄 License

This project is developed **for assessment purposes**.
You are free to modify and extend it.

---

## 👤 Author

**Faizal**
Laravel Developer
📍 Malaysia
