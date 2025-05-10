# Form Submission System

This is a simple form submission system built using PHP, MySQL, HTML, CSS, and JavaScript. The system allows users to submit their information (name, email, number, and date) through a form. The data is then stored in a MySQL database, and previously submitted data is displayed in a table below the form.

## Table of Contents

1. [Project Overview](#project-overview)
2. [Installation](#installation)
3. [Usage](#usage)
4. [Features](#features)
5. [Database Structure](#database-structure)
6. [License](#license)

## Project Overview

This project allows users to:

- Submit their personal information (name, email, number, and date).
- Check if the entered date matches today's date before submission (using JavaScript).
- View a list of previously submitted data stored in a MySQL database.

### Technologies Used:

- **PHP**: Backend server-side scripting.
- **MySQL**: Database management system.
- **HTML/CSS**: Frontend layout and design.
- **JavaScript**: Date validation before form submission.

## Installation

### Requirements:

- PHP 7.0 or higher
- MySQL
- A web server like Apache or Nginx
- A browser for testing

### Steps:

1. **Clone or Download the Repository**:
   Clone this repository or download the ZIP file and extract it to your web server's root directory.

2. **Database Setup**:
   - Create a database in MySQL (e.g., `test_db`).
   - Import the necessary table structure using the SQL script in the project.
   
   ```sql
   CREATE TABLE IF NOT EXISTS users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(100) NOT NULL,
       email VARCHAR(100) NOT NULL,
       number VARCHAR(20) NOT NULL
   );
