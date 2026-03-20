CREATE DATABASE IF NOT EXISTS touche_pas_au_klaxon;
USE touche_pas_au_klaxon;

CREATE TABLE IF NOT EXISTS agence (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR (100) NOT NULL,
    prenom VARCHAR (100) NOT NULL,
    telephone VARCHAR (20) NOT NULL,
    email VARCHAR (255) UNIQUE NOT NULL,
    password VARCHAR (255) NOT NULL,
    role ENUM('admin','user') NOT NULL DEFAULT 'user'
);

CREATE TABLE IF NOT EXISTS trajet (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agence_depart_id INT NOT NULL,
    agence_arrivee_id INT NOT NULL,
    datetime_depart DATETIME NOT NULL,
    datetime_arrivee DATETIME NOT NULL,
    places_total INT NOT NULL,
    places_dispo INT NOT NULL,
    utilisateur_id INT NOT NULL,

    FOREIGN KEY (agence_depart_id) REFERENCES agence(id),
    FOREIGN KEY (agence_arrivee_id) REFERENCES agence(id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id)
);
