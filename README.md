# TrackBook — Student Management System

TrackBook is a PHP and MySQL web application for managing student information and supporting student, teacher, and administrator workflows.

## Features
- Student registration and login
- Student profile viewing
- Teacher dashboard for viewing and filtering student records
- Attendance and grade fields
- Teacher update workflow with approval status
- Student feedback and read/unread status
- Administrator dashboard and management pages

> This README describes the functionality indicated by the included source files. Test each workflow locally before presenting it as production-ready.

## Technology Stack
- PHP
- MySQL
- HTML
- CSS
- JavaScript

## Requirements
- XAMPP, WAMP, or another PHP + MySQL environment
- A modern web browser

## Setup with XAMPP
1. Copy the `TrackBook` project folder into XAMPP's `htdocs` directory.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Open phpMyAdmin and import `schema.sql`. The script creates and selects the `trackbook` database.
4. Check `db.php` and set the `DB_HOST`, `DB_USER`, `DB_PASSWORD`, and `DB_NAME` environment variables if your local database differs from the defaults.
5. Visit `http://localhost/TrackBook/` in your browser (adjust the folder name if needed).

## Admin setup and security
- The repository SQL intentionally does not create a default administrator account with a known password. Create an administrator account locally using a secure password and the application's expected password-hashing format.
- Do not publish real student records, personal photos, passwords, API keys, or other private data.
- Before public deployment, review authentication and authorization, password hashing, SQL injection protections, input validation, CSRF protections, and error handling.
- This is a portfolio/student project and has not been security-audited.

## Repository Notes
- `.gitignore` excludes local secrets, logs, editor files, caches, and runtime uploads.
- Review all image assets before making the repository public. Keep only images you own or have permission to publish.

## Author
Prajwal Gouda
