# User Data Collector (UDC) Project 

This project demonstrates setting up a **User Data Collector application** using:
- **Apache (httpd)**
- **PHP 8.1**
- **MySQL Database**
- **Linux Server (CentOS/RHEL)**

---

## 📖 Features
- Collects user details (Name, Age, Country).
- Stores data securely in **MySQL** using Prepared Statements.
- Allows file uploads (stored in `/var/udc/uploads`).
- Secure DB connectivity between Web Server and DB Server.

---

## 📂 Project Structure
- `src/` → PHP source code (`php_test.php`, `db_check.php`, `main.php`)
- `docs/` → Setup documentation + screenshots
- `docs/screenshots/` → Environment & application screenshots

---

## ⚡ Setup Instructions
1. Install Apache + PHP  
2. Install MySQL Server  
3. Configure DB + create `udb` database  
4. Update `db_check.php` and `main.php` with your DB IP + credentials  
5. Open in browser → `http://<webserver-ip>/main.php`

---

## 📸 Screenshots
See [`docs/screenshots`](./docs/screenshots) folder for full setup steps and demo output.
