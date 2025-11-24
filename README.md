# CampusCrave 🍔

> **Skip the Line, Not the Lunch.**
> A web-based Canteen Automation System built to solve the rush-hour chaos in university cafeterias.

![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white) ![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white) ![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white) ![Status](https://img.shields.io/badge/Status-Completed-success?style=for-the-badge)

---

## 📖 Table of Contents
- [About The Project](#-about-the-project)
- [Key Features](#-key-features)
- [Tech Stack](#-tech-stack)
- [Detailed Database Schema](#-detailed-database-schema)
- [Installation Guide](#-installation-guide)
- [Usage](#-usage)
- [Future Improvements](#-future-improvements)
- [Contact](#-contact)

---

## 📝 About The Project
**CampusCrave** addresses a common problem in educational institutions: short break times and long queues. This project creates a digital bridge between students and the kitchen staff.

Students can browse the menu, place orders, and track their food status from their smartphones. Kitchen staff get a real-time dashboard to manage orders efficiently, reducing chaos and waiting times.

---

## 🚀 Key Features

### 🎓 For Students
* **Digital Menu:** Browse food items with images and prices in a responsive grid layout.
* **Smart Cart:** Add/Remove items and view total cost dynamically using PHP Sessions.
* **Real-Time Tracking:** Watch order status change from `Pending` 🟡 to `Preparing` 🟠 to `Ready` 🟢 (with glowing visual cues).
* **Order History:** View past orders and detailed receipts.

### 👨‍🍳 For Admin (Kitchen Staff)
* **Live Dashboard:** View incoming orders in real-time.
* **Order Management:** Update status with a single click (`Pending` → `Preparing` → `Ready`).
* **Menu CRUD:**
    * **Add:** Upload new food items with images.
    * **Remove:** Soft-delete items to hide them from the menu without breaking historical data.
* **Secure Access:** Role-based protected routes.

---

## 🛠 Tech Stack

| Component | Technology | Description |
| :--- | :--- | :--- |
| **Frontend** | HTML5, CSS3, JavaScript | Structure and basic interactivity |
| **Styling** | Bootstrap 5 + Custom CSS | Responsive Grid and Status Animations |
| **Backend** | PHP (Vanilla) | Server-side logic and Session Management |
| **Database** | MySQL | Relational Database for Users, Products, and Orders |
| **Security** | Password Hashing | `password_hash()` / `password_verify()` |

---

## 🗄 Detailed Database Schema

The system is built on a relational MySQL database with **4 interconnected tables**.

### 1. `users` Table
Stores login credentials and access levels.

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | `INT` (PK) | Unique User ID |
| `username` | `VARCHAR(50)` | Unique login name |
| `password` | `VARCHAR(255)` | **Hashed** password (security) |
| `role` | `ENUM` | Values: `'student'`, `'admin'` |
| `created_at` | `TIMESTAMP` | Account creation time |

### 2. `products` Table
Stores the menu items available in the canteen.

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | `INT` (PK) | Unique Product ID |
| `name` | `VARCHAR(100)` | Name of the food item |
| `price` | `DECIMAL(10,2)` | Cost per unit |
| `image` | `VARCHAR(255)` | Filename stored in `assets/images/` |
| `is_active` | `TINYINT(1)` | `1` = Visible, `0` = Soft Deleted |

### 3. `orders` Table
Represents the "Head" of an order (Who bought it and when).

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | `INT` (PK) | Unique Order ID |
| `user_id` | `INT` (FK) | Links to `users.id` |
| `total_price` | `DECIMAL(10,2)` | Grand total of the order |
| `status` | `ENUM` | `pending`, `preparing`, `ready`, `completed` |
| `created_at` | `TIMESTAMP` | Time of order placement |

### 4. `order_items` Table
Represents the "Body" of an order (Specific items).

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | `INT` (PK) | Unique Item Entry ID |
| `order_id` | `INT` (FK) | Links to `orders.id` |
| `product_id` | `INT` (FK) | Links to `products.id` |
| `quantity` | `INT` | Number of items ordered |
| `price_at_purchase`| `DECIMAL(10,2)`| Price frozen at time of purchase |

---

## ⚙️ Installation Guide

Follow these steps to run the project locally.

### Prerequisites
* **XAMPP** (or WAMP/MAMP) installed.
* A web browser.

### Steps
1.  **Clone the Repo**
    Download this folder and place it in your `htdocs` directory (e.g., `C:\xampp\htdocs\campus-crave`).

2.  **Setup Database**
    * Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
    * Create a new database named `campus_crave`.
    * Import the provided SQL file or run the SQL queries manually to create tables.

3.  **Configure Connection**
    * Open `config/db.php`.
    * Ensure `$username` is `root` and `$password` is empty (default XAMPP settings).

4.  **Run the App**
    * Open your browser and go to: `http://localhost/campus-crave/`

---

## 📸 Usage

### Default Credentials
Use these to log in and test the system:

| Role | Username | Password |
| :--- | :--- | :--- |
| **Admin** | `admin` | `admin123` |
| **Student** | `student1` | `pass123` |

### How to Test
1.  Log in as **Student** (Incognito window recommended).
2.  Add items to cart and Checkout.
3.  Log in as **Admin** (Normal window).
4.  Change the status of the new order to **"Ready"**.
5.  Refresh Student window to see the **Green Glowing Badge**.

---

## 🔮 Future Improvements
* [ ] Add Payment Gateway integration (Stripe/PayPal).
* [ ] Email notifications for Order Ready status.
* [ ] "Most Popular Items" analytics for Admin.
* [ ] Forgot Password functionality.

---

## 📬 Contact


---

*Project created for Web Engineering Course (2024)*
