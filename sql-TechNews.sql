CREATE DATABASE TechNews;

USE TechNews;

CREATE TABLE users (
	id INT unsigned NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(150) NOT NULL,
    last_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    banner VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'registered',
    password_recovery VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY(id)
);

CREATE TABLE categories (
	id INT unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(100) NOT NULL UNIQUE,
    uri VARCHAR(150) NOT NULL UNIQUE
);

CREATE TABLE articles (
	id INT unsigned NOT NULL AUTO_INCREMENT,
    id_user INT unsigned NOT NULL,
    id_category INT unsigned NOT NULL,
    title VARCHAR(255) NOT NULL UNIQUE,
    subtitle TEXT NOT NULL,
    uri VARCHAR(255) NOT NULL UNIQUE,
    cover VARCHAR(255) NOT NULL,
    video VARCHAR(255) DEFAULT NULL,
    views INT NOT NULL DEFAULT 0,
    status VARCHAR(50) NOT NULL DEFAULT 'created',
    published_at TIMESTAMP NULL DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (id_user) REFERENCES users (id),
	FOREIGN KEY (id_category) REFERENCES categories (id)
);

CREATE TABLE paragraphs (
	id INT unsigned NOT NULL AUTO_INCREMENT,
    id_article INT unsigned NOT NULL,
    title VARCHAR(255) DEFAULT NULL,
    paragraph TEXT NOT NULL,
    position INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_article) REFERENCES articles (id)
);

CREATE TABLE comments (
	id INT unsigned NOT NULL AUTO_INCREMENT,
    id_user INT unsigned NOT NULL,
    id_article INT unsigned NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (id_user) REFERENCES users (id),
    FOREIGN KEY (id_article) REFERENCES articles (id)
);

CREATE FULLTEXT INDEX search ON articles(title, subtitle);