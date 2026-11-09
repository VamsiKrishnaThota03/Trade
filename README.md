# Trade

A PHP + MySQL import/export marketplace: registered users list goods for trade and place import or export requests for listed items.

![PHP](https://img.shields.io/badge/PHP-mysqli-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-CSS3-E34F26?logo=html5&logoColor=white)

## Overview

Trade is a server-rendered PHP website built around Importer Exporter Code (IEC) style trading. After signing up and logging in, a user lands on a trade dashboard. From there they can import an item (search the available listings by product type and request a quantity), export an item (search by product type and name and submit export details), or add their own items to the catalogue. Each trade lowers the available quantity and is recorded in an import or export table and in a combined `total_table`.

## Features

- Landing page with IEC information and links to the DGFT help pages.
- Sign up (name, age, sex, phone, email, password, city, pincode, country) and log in with PHP sessions, plus logout.
- A trade dashboard with Import, Export and Add Items actions, illustrated with static chart images.
- **Add items**: list a product with its type, name, origin country, quantity and price.
- **Import flow** (`7_import.php` → `8_import.php` → `9_import.php` → `11_import.php`): search by product type, pick a listing, enter your contact and destination details, and submit. Stock is reduced by the requested quantity.
- **Export flow** (`12_export.php` → `15_export.php` → `13_export.php` → `14_export.php`): search by type and name, pick a listing, enter your details, and submit.
- A draft forgot-password page (`fp.php`, `fp1.php`).

## Tech stack

- PHP (procedural, `mysqli`)
- MySQL / MariaDB
- HTML and CSS (`2_style.css`)

## Project structure

```
Trade/
├── 1_main_page.php      # public landing page
├── 2_style.css
├── 3_conn.php           # database connection settings
├── 4_login.php          # login
├── 5_signUp.php         # registration
├── 6_trade.php          # dashboard after login
├── 7_import.php … 11_import.php   # import flow
├── 12_export.php … 15_export.php  # export flow
├── 10_add_items.php     # add a listing
├── 11_logOut.php
├── 21_main.php          # landing page for logged-in users
├── header.php, footer.php, footer1.php
├── fp.php, fp1.php      # forgot password (draft)
└── *.png / *.jpg        # page images and chart graphics
```

## Getting started

### Prerequisites

- PHP 7.4 or later with the `mysqli` extension
- MySQL or MariaDB. A bundle such as XAMPP, WAMP or MAMP works well.

### 1. Get the code

Clone the repo into your web server's document root, for example `htdocs/` in XAMPP:

```bash
git clone https://github.com/VamsiKrishnaThota03/Trade.git
```

### 2. Create the database

The repository does not include a SQL dump. Create a database named `project` and the tables the code expects. The column order below is inferred from the `INSERT` statements, so adjust the types as needed:

```sql
CREATE DATABASE project;
USE project;

CREATE TABLE user (
  email VARCHAR(100) PRIMARY KEY, uname VARCHAR(100), uage INT, usex VARCHAR(10),
  password VARCHAR(255), ucity VARCHAR(100), upincode VARCHAR(10), uphone VARCHAR(15), country VARCHAR(100)
);

CREATE TABLE available (
  email VARCHAR(100), pid INT PRIMARY KEY, ptype VARCHAR(100), pname VARCHAR(100),
  country VARCHAR(100), qty INT, price VARCHAR(20)
);

CREATE TABLE import_data (
  email VARCHAR(100), uname VARCHAR(100), phone BIGINT, city VARCHAR(100), origin_country VARCHAR(100),
  pid INT, ptype VARCHAR(100), pname VARCHAR(100), dest_country VARCHAR(100), price VARCHAR(20)
);

CREATE TABLE export_data LIKE import_data;

CREATE TABLE total_table (
  email VARCHAR(100), uname VARCHAR(100), pid INT, ptype VARCHAR(100), pname VARCHAR(100),
  trade_type VARCHAR(10), price VARCHAR(20)
);
```

You can run this in phpMyAdmin (SQL tab) or with `mysql -u root -p < schema.sql`.

### 3. Configure the connection

Edit `3_conn.php`:

| Variable   | Description       | Default     |
| ---------- | ----------------- | ----------- |
| `$db_host` | MySQL host        | `localhost` |
| `$db_user` | MySQL user        | `root`      |
| `$db_pass` | MySQL password    | `<your-db-password>` |
| `$db_name` | Database name     | `project`   |

### 4. Run

Start Apache and MySQL, then open `http://localhost/Trade/1_main_page.php`.

## Security note

This is a learning project and is not safe to deploy as-is. Queries are built by string concatenation, so they are open to SQL injection, and passwords are stored and compared in plain text. Before any public use, switch to prepared statements and `password_hash()` / `password_verify()`.
