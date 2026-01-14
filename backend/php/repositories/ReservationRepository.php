<?php

require_once __DIR__ . '/../db_connect.php';
require_once __DIR__ . '/../../utils/Tools.php';
require_once __DIR__ . '/../models/Reservation.php';



class ReservationRepository
{
    private PDO $connexion;

    public function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }

    /**
     * Crée une nouvelle réservation en base de données
     * 
     * @param Reservation $reservation
     * @return int|false L'ID de la réservation créée ou false en cas d'erreur
     */
    public function EnregistrementReservation(Reservation $reservation): int|false
    {
        try {
            // Préparation de la requête SQL
            $sql = 'INSERT INTO Réservation (nom, email, telephone, nb_personnes, date_reservation, midi, soir) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)';
            // Execution de la requête
            $req = $this->connexion->prepare($sql);
            // Liaison des paramètres et exécution
            $success = $req->execute([
                $reservation->getNom(),
                $reservation->getEmail(),
                $reservation->getTelephone(),
                $reservation->getNbPersonnes(),
                $reservation->getDateReservation(),
                $reservation->getMidi(),
                $reservation->getSoir()
            ]);

            return $success ? (int)$this->connexion->lastInsertId() : false;
        } catch (PDOException $e) {
            error_log('Erreur lors de la création de la réservation : ' . $e->getMessage());
            return false;
        }
    }
}
