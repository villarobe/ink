# 🌊 Waves of Ink — Setup Guide

## Folder Structure
```
waves_of_ink/
├── index.php          ← Dashboard (main page)
├── process.php        ← AJAX CRUD + upload handler
├── db_connection.php  ← PDO database connection
├── style.css          ← Brown/Pink vintage theme
├── DATABASE.sql       ← Table creation + seed data
├── uploads/           ← Book cover images (create this!)
└── README.md          ← This file
```

---

## Step-by-Step Setup

### 1. Prerequisites
- **XAMPP** (or WAMP / MAMP / Laragon) with PHP 8.1+ and MySQL 5.7+
- Web browser

### 2. Place the Files
Copy the `waves_of_ink/` folder into your server's web root:
- XAMPP → `C:/xampp/htdocs/waves_of_ink/`
- WAMP  → `C:/wamp64/www/waves_of_ink/`
- Linux → `/var/www/html/waves_of_ink/`

### 3. Create the `uploads/` Directory
Inside the `waves_of_ink/` folder, create an empty folder named **`uploads`**.

On Windows: right-click → New → Folder → name it `uploads`  
On Linux/Mac: `mkdir uploads && chmod 755 uploads`

### 4. Create the Database
1. Open **phpMyAdmin** → `http://localhost/phpmyadmin`
2. Click **"New"** → name it `waves_of_ink` → click **Create**
3. Select the database → click the **SQL** tab
4. Open `DATABASE.sql`, copy all contents, paste into the SQL tab → click **Go**
5. You should now see a `books` table (with 4 sample rows).

### 5. Configure the Database Password
Open `db_connection.php` and update these two lines:
```php
define('DB_USER', 'root');   // your MySQL username
define('DB_PASS', '');       // your MySQL password (blank for default XAMPP)
```

### 6. Start Your Server
- Open XAMPP Control Panel → click **Start** on **Apache** and **MySQL**

### 7. Open the App
Visit: `http://localhost/waves_of_ink/`

---

## Features
| Feature | Details |
|---|---|
| **Gallery View** | Responsive grid, filters by Author / Status |
| **View Modal** | Full description, genre, age rating, trigger warnings |
| **Add / Edit** | Bootstrap modal, no page redirect, live cover preview |
| **Delete** | Confirmation modal, removes file from `uploads/` |
| **Image Upload** | MIME-validated, max 2 MB, stored in `uploads/` |
| **Security** | PDO prepared statements, server-side whitelist validation |

---

## Customising the Colour Palette
All colours are CSS variables in `style.css` (top of file):
```css
--brown-dark:  #5C3317;   /* darkest brown */
--rose-mid:    #D4939B;   /* dusty rose */
--rose-pale:   #F5E6E8;   /* almost white pink */
```
Change any hex value to restyle the whole app instantly.

---

## Troubleshooting
| Problem | Fix |
|---|---|
| "Database connection failed" | Check `DB_USER` / `DB_PASS` in `db_connection.php` |
| Images not saving | Ensure `uploads/` folder exists and is writable |
| Blank page | Enable PHP error reporting or check Apache error log |
| Fonts not loading | Requires internet connection (Google Fonts CDN) |
