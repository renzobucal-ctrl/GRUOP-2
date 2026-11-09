CREATE DATABASE IF NOT EXISTS water_station
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE water_station;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    fullname VARCHAR(100) NOT NULL,
    username VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(11) NOT NULL DEFAULT '',
    address VARCHAR(255) NOT NULL,
    landmark VARCHAR(150) NOT NULL DEFAULT '',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY users_username_unique (username)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
