# Bhagyarekha Setup (XAMPP)

## 1) Create/import database

- Database name: `bhagyarekha`
- Import SQL: `database/bhagyarekha.sql`
- MySQL user/pass (local): `root` / `root`

You can import using phpMyAdmin:

- Open: `http://localhost/phpmyadmin`
- Select database `bhagyarekha` (or create it)
- Import `database/bhagyarekha.sql`

## 2) Configure DB connection

Edit `config/config.local.php` if needed.

## 3) Open website + admin

- Website: `http://localhost/bhagyarekha/`
- Admin: `http://localhost/bhagyarekha/admin/`

Admin seed user (from SQL):

- Username: `admin`
- Password: `admin123`

Change the password after first login (page can be added next).

