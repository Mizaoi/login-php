CREATE DATABASE IF NOT EXISTS db_login;
USE db_login;

CREATE TABLE IF NOT EXISTS tb_login (
    id_user  INT(11)      AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, 
    role     ENUM('admin','mahasiswa') NOT NULL DEFAULT 'mahasiswa'
);

TRUNCATE TABLE tb_login;
INSERT INTO tb_login (username, password, role) VALUES
('admin', MD5('admin123'), 'admin'),
('wisatawan', MD5('wisata123'), 'mahasiswa');