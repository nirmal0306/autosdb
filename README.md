# 🚗 Autos Database 

This project is part of my learning php and i am glad to share this project with you all.
It is a simple PHP + MySQL web application that allows users to:

- Log in securely using PHP sessions
- Add automobile records (make, year, mileage)
- Validate inputs (year & mileage must be numeric, make is required)
- View all automobile records in a styled table
- Log out and end the session

---

## 📂 Project Structure

## autosdb/

│
## autosdb/

│── add.php          # Form to add a new automobile record (make, year, mileage)

│── autos.php        # Main page showing all automobiles + edit/delete actions

│── autos.sql        # SQL file to create the `autos` table (schema + sample data)

│── config.php       # Database connection file (PDO or MySQLi config)

│── delete.php       # Script to delete an automobile by its auto_id

│── edit.php         # Form to edit an existing automobile record

│── index.php        # Entry / home page (often login redirect or welcome page)

│── login.php        # User login page (start session, validate user)

│── logout.php       # Logout script (destroy session, redirect to login)

│── README.md        # Project documentation (setup steps, usage, notes)

│── style.css        # Central stylesheet for consistent UI design

---

## ⚙️ Setup Instructions

1. Install **XAMPP** or **MAMP** (PHP + MySQL).
2. Copy the `autosdb` folder into your `htdocs` (or `www`) directory.
3. Create a new MySQL database:

   ```sql
   CREATE TABLE autos (
    auto_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    make VARCHAR(128) NOT NULL,
    year INT NOT NULL,
    mileage INT NOT NULL,
    PRIMARY KEY(auto_id)
);

