-- Trade database schema (MySQL 5.7+ / MariaDB 10.3+).
--
--   mysql -u root -p < schema.sql
--
-- Creates the `project` database (the default DB_NAME) and all tables used
-- by the application. Safe to re-run: existing tables are left untouched.

CREATE DATABASE IF NOT EXISTS project
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE project;

-- Registered traders. `password` holds a password_hash() value.
CREATE TABLE IF NOT EXISTS user (
    email     VARCHAR(190) NOT NULL PRIMARY KEY,
    uname     VARCHAR(100) NOT NULL,
    uage      INT          NULL,
    usex      VARCHAR(10)  NULL,
    password  VARCHAR(255) NOT NULL,
    ucity     VARCHAR(100) NULL,
    upincode  VARCHAR(10)  NULL,
    uphone    VARCHAR(20)  NULL,
    country   VARCHAR(100) NULL,
    created_at TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Goods listed for trade. `email` is the trader who listed the item.
CREATE TABLE IF NOT EXISTS available (
    pid      INT UNSIGNED  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email    VARCHAR(190)  NOT NULL,
    ptype    VARCHAR(100)  NOT NULL,
    pname    VARCHAR(100)  NOT NULL,
    country  VARCHAR(100)  NOT NULL,
    qty      INT UNSIGNED  NOT NULL DEFAULT 0,
    price    DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_available_type (ptype),
    KEY idx_available_type_name (ptype, pname),
    CONSTRAINT fk_available_user FOREIGN KEY (email) REFERENCES user (email)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- Import requests placed against a listing.
CREATE TABLE IF NOT EXISTS import_data (
    id             INT UNSIGNED  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email          VARCHAR(190)  NOT NULL,
    uname          VARCHAR(100)  NOT NULL,
    phone          VARCHAR(20)   NOT NULL,
    city           VARCHAR(100)  NOT NULL,
    origin_country VARCHAR(100)  NOT NULL,
    pid            INT UNSIGNED  NOT NULL,
    ptype          VARCHAR(100)  NOT NULL,
    pname          VARCHAR(100)  NOT NULL,
    dest_country   VARCHAR(100)  NOT NULL,
    qty            INT UNSIGNED  NOT NULL,
    price          DECIMAL(12,2) NOT NULL,
    created_at     TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_import_email (email)
) ENGINE=InnoDB;

-- Export requests placed against a listing (same shape as import_data).
CREATE TABLE IF NOT EXISTS export_data (
    id             INT UNSIGNED  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email          VARCHAR(190)  NOT NULL,
    uname          VARCHAR(100)  NOT NULL,
    phone          VARCHAR(20)   NOT NULL,
    city           VARCHAR(100)  NOT NULL,
    origin_country VARCHAR(100)  NOT NULL,
    pid            INT UNSIGNED  NOT NULL,
    ptype          VARCHAR(100)  NOT NULL,
    pname          VARCHAR(100)  NOT NULL,
    dest_country   VARCHAR(100)  NOT NULL,
    qty            INT UNSIGNED  NOT NULL,
    price          DECIMAL(12,2) NOT NULL,
    created_at     TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_export_email (email)
) ENGINE=InnoDB;

-- Combined log of every trade, used by the "My trades" page.
CREATE TABLE IF NOT EXISTS total_table (
    id         INT UNSIGNED  NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email      VARCHAR(190)  NOT NULL,
    uname      VARCHAR(100)  NOT NULL,
    pid        INT UNSIGNED  NOT NULL,
    ptype      VARCHAR(100)  NOT NULL,
    pname      VARCHAR(100)  NOT NULL,
    trade_type ENUM('import', 'export') NOT NULL,
    qty        INT UNSIGNED  NOT NULL,
    price      DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_total_email (email)
) ENGINE=InnoDB;
