# 🚗 Autos Database (WA4E Assignment)

This project is part of the [Building Database Applications in PHP (WA4E)](https://www.wa4e.com/) course.  
It is a simple PHP + MySQL web application that allows users to:

- Log in securely using PHP sessions
- Add automobile records (make, year, mileage)
- Validate inputs (year & mileage must be numeric, make is required)
- View all automobile records in a styled table
- Log out and end the session

---

## 📂 Project Structure

autosdb/
│
├── config.php # Database connection
├── index.php # Redirects to login or autos.php
├── login.php # Login page
├── autos.php # Main application page
├── logout.php # Logout script
├── style.css # Styling for the app
└── README.md # Project documentation

---

## ⚙️ Setup Instructions

1. Install **XAMPP** or **MAMP** (PHP + MySQL).
2. Copy the `autosdb` folder into your `htdocs` (or `www`) directory.
3. Create a new MySQL database:

   ```sql
   CREATE DATABASE autosdb;
   USE autosdb;
   CREATE TABLE autos (
       auto_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
       make VARCHAR(128),
       year INT,
       mileage INT
   );
