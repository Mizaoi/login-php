-- FILE: database.sql
-- Cukup ini saja yang dibutuhkan

-- 1. Buat database
CREATE DATABASE IF NOT EXISTS db_login;
USE db_login;

-- 2. dipakai di register.php & login.php
CREATE TABLE IF NOT EXISTS tb_login (
    id_user  INT(11)      AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    role     ENUM('admin','mahasiswa') NOT NULL DEFAULT 'mahasiswa'
);

-- 3. biar bisa langsung login
INSERT INTO tb_login (username, password, role) VALUES
('admin',     MD5('admin123'), 'admin'),
('budi',      MD5('budi123'),  'mahasiswa'),
('sari',      MD5('sari123'),  'mahasiswa');

-- SELESAI! Cuma ini doang.