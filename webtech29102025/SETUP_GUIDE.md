# MySQL Setup Guide

## Current Status
The application now requires MySQLi extension to work with MySQL database directly.

## Required Setup

### 1. Enable MySQLi Extension

#### If using XAMPP:
1. Open XAMPP Control Panel
2. Start MySQL service
3. Click "Config" next to Apache
4. Select "PHP (php.ini)"
5. Find this line and uncomment it (remove the semicolon):
   ```ini
   extension=mysqli
   ```
6. Save the file and restart Apache

#### If using WAMP:
1. Click on WAMP icon in system tray
2. Go to PHP → PHP Extensions
3. Enable "mysqli"
4. Restart WAMP services

#### If using standalone PHP:
1. Find your `php.ini` file
2. Uncomment this line:
   ```ini
   extension=mysqli
   ```
3. Restart your web server

### 2. Start MySQL Server
Make sure MySQL server is running:
- **XAMPP**: Start MySQL from control panel
- **WAMP**: Start MySQL service
- **Manual**: Start MySQL service on your system

### 3. Configure Database Credentials
Update `config.php` with your MySQL credentials:
```php
$host = 'localhost';
$username = 'root';        // Your MySQL username
$password = 'your_password'; // Your MySQL password
```

## Testing Your Setup

1. Run the application: `php -S localhost:8000`
2. Visit `http://localhost:8000/phpinfo.php` to check MySQLi and test connection
3. Visit `http://localhost:8000/index.html` to use the application

## Troubleshooting

### MySQLi Not Available
- Check if extension is enabled in php.ini
- Restart web server after enabling extension
- Verify PHP installation includes MySQLi

### MySQL Connection Failed
- Ensure MySQL server is running
- Check username/password in config.php
- Verify MySQL is accessible on localhost:3306

### Database Creation Fails
- Check MySQL user has CREATE privileges
- Verify database name doesn't contain special characters
- Ensure MySQL server is running

## Application Features
- ✅ Create MySQL databases
- ✅ Create tables with specified columns
- ✅ Insert student records
- ✅ Search by ID, First Name, or Last Name
- ✅ Modern responsive interface
