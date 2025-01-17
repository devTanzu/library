# Library Management System

## Project Overview
The Library Management System is a web-based application designed to manage the daily operations of a library efficiently. This system simplifies tasks such as book cataloging, member management, borrowing, and returning books, providing a seamless experience for both librarians and users.

---

## Features
- **Book Management**: Add, update, search, and delete book records.
- **Member Management**: Register new members, update their details, and manage member accounts.
- **Borrowing and Returning**: Track book borrowings and returns, including due dates and penalties for late returns.
- **Search Functionality**: Search for books or members using various criteria.
- **Admin Panel**: Role-based access for librarians and administrators to manage the system.

---

## Technologies Used
- **Frontend**: HTML, CSS
- **Backend**: PHP
- **Database**: MySQL

---

## Installation

### Prerequisites
1. Web server (e.g., XAMPP, WAMP, or any server with PHP support).
2. MySQL installed and running.

### Steps
1. Clone this repository:
   ```bash
   git clone https://github.com/devTanzu/library.git
   ```
2. Move the project folder to your web server’s root directory (e.g., `htdocs` for XAMPP).
3. Import the database:
   - Open `phpMyAdmin`.
   - Create a new database (e.g., `library_db`).
   - Import the SQL file located at `/database/library_db.sql`.
4. Configure the database connection:
   - Open the `config.php` file in the root directory.
   - Update the database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', '');
     define('DB_NAME', 'library_db');
     ```
5. Start the web server and access the application in your browser:
   ```
   http://localhost/library
   ```

---

## Usage
1. **Login**:
   - Use the default admin credentials (if applicable):
     - Username: `admin`
     - Password: `admin123`
   - Update the credentials after logging in.
2. **Manage Books**:
   - Navigate to the "Books" section to add, edit, or remove books.
3. **Manage Members**:
   - Navigate to the "Members" section to register or update member information.
4. **Issue and Return**:
   - Use the "Borrow" and "Return" sections to manage transactions.

---

## Project Structure
```
library/
|-- assets/          # CSS, JS, and images
|-- database/        # SQL files
|-- includes/        # Reusable PHP components
|-- config.php       # Database configuration
|-- index.php        # Main entry point
|-- ...              # Other files and folders
```

---

## Future Enhancements
- Add email notifications for due dates.
- Implement advanced reporting features.
- Enable integration with e-book platforms.

---

## Additional Resources
- [Project Presentation (PDF)](C:/xampp/htdocs/library/presentation_compressed.pdf)
- [Project Demo (Video)](C:/xampp/htdocs/library/LMS.mp4)
