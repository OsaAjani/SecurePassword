#Fichier de création de la base
CREATE DATABASE IF NOT EXISTS secure_password;
use secure_password;

-- Create table of users
CREATE TABLE IF NOT EXISTS users
(
	id INT NOT NULL AUTO_INCREMENT,
	email VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	secret_key VARCHAR(1000) NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (email)
);

-- Ajout du champs valid
ALTER TABLE users ADD valid BOOLEAN NOT NULL DEFAULT 0;

-- Create table of groups
CREATE TABLE IF NOT EXISTS groups
(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	user_id INT NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (name, user_id),
	INDEX groups_user_id (user_id),
	FOREIGN KEY (user_id)
		REFERENCES users(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);

-- Create table of passwords
CREATE TABLE IF NOT EXISTS passwords
(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	content VARCHAR(1000) NOT NULL,
	group_id INT NOT NULL,
	PRIMARY KEY (id),
	UNIQUE (name,group_id),
	INDEX passwords_group_id (group_id),
	FOREIGN KEY (group_id)
		REFERENCES groups(id)
		ON DELETE CASCADE
		ON UPDATE CASCADE
);
