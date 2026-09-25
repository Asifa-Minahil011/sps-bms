# SPS Business Management System (SPS-BMS)

SPS-BMS is a web-based Business Management System developed for Software Productivity Strategists (SPS).

The system provides employee management, HR workflows, performance management, onboarding/offboarding, TimeLive records, employee documents, certifications, plans, KPI records and other employee-related functionality.

## Technologies Used

- HTML5
- CSS3
- JavaScript
- PHP
- MySQL / MariaDB
- XAMPP
- phpMyAdmin

## Project Setup

### 1. Install XAMPP

Download and install XAMPP.

Start:

- Apache
- MySQL

### 2. Copy the Project

Place the project folder inside:

C:\xampp\htdocs\

The final location should be:

C:\xampp\htdocs\sps-bms

### 3. Create the Database

Open:

http://localhost/phpmyadmin/

Create a database named:

sps_bms

### 4. Import the Database

Select the `sps_bms` database.

Go to:

Import → Choose File

Select:

database/sps_bms.sql

Then click Import.

### 5. Database Configuration

Database configuration is located in:

config/db.php

Default XAMPP configuration:

Host: localhost  
Username: root  
Password:  
Database: sps_bms

### 6. Run the Application

Open:

http://localhost/sps-bms/

## Main Features

- Employee Management
- Employee Detail
- Education Records
- Corporate Roles
- Departmental Roles
- Employment History
- Department Customers
- Projects
- Products
- Learning & Development
- Attachments
- Communication Skills
- Badges
- Certifications
- KPI Management
- Loaded Cost
- HR Talk
- Hours Distribution
- Employee Blog
- Forms
- Development Plans
- Performance
- TimeLive
- Weekly Performance
- Onboarding
- Orientation Plan
- Offboarding
- Employee Letters

## Database

The exported database file is available at:

database/sps_bms.sql