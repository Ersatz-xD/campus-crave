# CampusCrave 🍔

> **Skip the Line, Not the Lunch.**
> A web-based Canteen Automation System built to solve the rush-hour chaos in university cafeterias.

![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white) ![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white) ![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white) ![Status](https://img.shields.io/badge/Status-Completed-success?style=for-the-badge)

---

## 📖 Table of Contents
- [About The Project](#-about-the-project)
- [Key Features](#-key-features)
- [Tech Stack](#-tech-stack)
- [Database Schema](#-database-schema)
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

## 🗄 Database Schema

The system uses 4 main relational tables:

1.  **`users`**: Stores login credentials and Roles (`admin` vs `student`).
2.  **`products`**: Stores food menu details, prices, and image filenames.
3.  **`orders`**: Stores the "Head" of the order (User ID, Total Price, Status, Timestamp).
4.  **`order_items`**: Stores the "Body" of the order (Which specific items belong to which Order ID).

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



