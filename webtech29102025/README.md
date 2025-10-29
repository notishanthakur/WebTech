# Database Management System

A web-based database management system built with HTML, CSS, PHP, and JavaScript that allows you to create databases, tables, insert records, and search data.

## Features

- **Database Creation**: Create MySQL databases with custom names
- **Table Creation**: Create tables with predefined columns (ID, FNAME, LNAME, REGNI, SEC, ADDRESS)
- **Record Insertion**: Insert student records into the database
- **Search Functionality**: Search records by ID, First Name, or Last Name
- **Responsive Design**: Modern, mobile-friendly interface
- **Real-time Feedback**: Status messages for all operations

## Requirements

- PHP 7.0 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or PHP built-in server

## Setup Instructions

1. **Database Configuration**:
   - Open `config.php`
   - Update the database credentials:
     ```php
     $host = 'localhost';
     $username = 'root';  // Your MySQL username
     $password = '';      // Your MySQL password
     ```

2. **File Structure**:
   ```
   webtech29102025/
   ├── index.html
   ├── styles.css
   ├── script.js
   ├── api.php
   ├── config.php
   └── README.md
   ```

3. **Running the Application**:
   
   **Option 1: Using PHP Built-in Server**
   ```bash
   php -S localhost:8000
   ```
   Then open `http://localhost:8000` in your browser.
   
   **Option 2: Using XAMPP/WAMP**
   - Place the files in your web server's document root (e.g., `htdocs` folder)
   - Start Apache and MySQL services
   - Open `http://localhost/webtech29102025` in your browser

## Usage

1. **Create Database**:
   - Enter a database name in the "Database Name" field
   - Click "Create Database" button

2. **Create Table**:
   - Enter a table name in the "Table Name" field
   - Click "Create Table" button

3. **Insert Records**:
   - Fill in the student information (First Name, Last Name, Registration Number, Section are required)
   - Address is optional
   - Click "Insert Record" button

4. **Search Records**:
   - Use any combination of ID, First Name, or Last Name to search
   - Click "Search" button to see results
   - Use "Clear" button to reset search

## Database Schema

The system creates tables with the following structure:
- `ID` (INT, AUTO_INCREMENT, PRIMARY KEY)
- `FNAME` (VARCHAR(100), NOT NULL)
- `LNAME` (VARCHAR(100), NOT NULL)
- `REGNI` (VARCHAR(50), NOT NULL)
- `SEC` (VARCHAR(10), NOT NULL)
- `ADDRESS` (TEXT)
- `created_at` (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP)

## Troubleshooting

- **Connection Error**: Check your MySQL credentials in `config.php`
- **Permission Denied**: Ensure your MySQL user has CREATE, INSERT, SELECT privileges
- **File Not Found**: Make sure all files are in the same directory
- **CORS Issues**: If running on different ports, ensure your web server is properly configured

## Browser Compatibility

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Security Notes

- This is a demo application and should not be used in production without proper security measures
- Consider implementing input validation, prepared statements (already implemented), and user authentication for production use

