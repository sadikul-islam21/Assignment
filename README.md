# Student Information System

A simple web application for managing student information using HTML, PHP, and MySQL.

## Features

- **Student Registration Form**: Collect student name, ID, and department
- **Data Validation**: Client-side and server-side validation
- **Database Storage**: Store student information in MySQL database
- **View Students**: Display all registered students
- **Responsive Design**: Works on desktop and mobile devices

## Files Description

### 1. `database_setup.sql`
SQL script to create the database and table structure.

### 2. `index.html`
HTML form for student registration with:
- Student name input
- Student ID input (9-digit validation)
- Department selection dropdown
- Form validation

### 3. `process_form.php`
PHP script that:
- Processes form submissions
- Validates input data
- Stores information in MySQL database
- Handles errors and duplicate entries
- Displays success/error messages

### 4. `view_students.php`
PHP script to display all registered students in a table format.

### 5. `style.css`
CSS file with modern styling and responsive design.

## Setup Instructions

### 1. Database Setup
1. Start your MySQL server
2. Import the database structure:
   ```bash
   mysql -u root -p < database_setup.sql
   ```
   Or run the SQL commands in your MySQL client.

### 2. Configuration
1. Edit the database configuration in both `process_form.php` and `view_students.php`:
   ```php
   $servername = "localhost";
   $username = "your_mysql_username";  // Usually "root"
   $password = "your_mysql_password";  // Your MySQL password
   $dbname = "student_db";
   ```

### 3. Web Server Setup
1. Place all files in your web server directory (htdocs for XAMPP, www for WAMP)
2. Start your web server (Apache)
3. Access the application at: `http://localhost/your-folder-name/`

## Usage

1. **Add Student**: Open `index.html` and fill out the form
2. **View Students**: Click "View All Students" or go to `view_students.php`
3. **Form Validation**: The system validates:
   - Required fields
   - Student ID format (exactly 9 digits)
   - Duplicate student IDs

## Database Structure

```sql
Table: students
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- name (VARCHAR(100), NOT NULL)
- student_id (VARCHAR(20), UNIQUE, NOT NULL)
- department (VARCHAR(100), NOT NULL)
- created_at (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)
```

## Student ID Format
- Exactly 9 digits (e.g., 222014027)
- Must be unique in the database

## Technologies Used
- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Features**: Form validation, responsive design, error handling

## Browser Compatibility
- Chrome, Firefox, Safari, Edge
- Mobile responsive design

## Security Features
- SQL injection prevention using prepared statements
- Input sanitization and validation
- XSS protection with htmlspecialchars()
- Form validation on both client and server side
