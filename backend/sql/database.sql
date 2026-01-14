CREATE DATABASE LaGuingettedeVilledubert;
USE LaGuingettedeVilledubert;

CREATE TABLE Réservation (
   id_reservation INT NOT NULL AUTO_INCREMENT,
   nom VARCHAR(100) NOT NULL,
   email VARCHAR(100) NOT NULL,
   telephone VARCHAR(20) NOT NULL,
   nb_personnes INT NOT NULL,
   date_reservation DATE,
   midi TIME,
   soir TIME,
   
   PRIMARY KEY (id_reservation)
   )ENGINE=innoDB;
