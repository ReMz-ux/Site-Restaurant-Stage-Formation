<?php

require_once __DIR__ . '/../repositories/ReservationRepository.php';
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../../utils/Tools.php';
require_once __DIR__ . '/../db_connect.php';

class ReservationController
{
    // Attributs
    private ReservationRepository $reservation_repository;
    // Constructeur
    public function __construct(ReservationRepository $reservation_repository)
    {
        $this->reservation_repository = $reservation_repository;
    }


    public function createReservation()
    {
        //Verifier les champs remplis
        if (isset($_POST['nom'], $_POST['email'], $_POST['telephone'], $_POST['nb_personnes'], $_POST['date_reservation'], $_POST['midi'], $_POST['soir'])) {
            //Sanitize les champs
            $nom = Tools::sanitizeString($_POST['nom']);
            $email = Tools::sanitizeEmail($_POST['email']);
            $telephone = Tools::sanitizePhone($_POST['telephone']);
            $nb_personnes = Tools::sanitizeInt($_POST['nb_personnes']);
            $date_reservation = Tools::sanitizeDate($_POST['date_reservation']);
            $midi = Tools::sanitizeString($_POST['midi']);
            $soir = Tools::sanitizeString($_POST['soir']);

            //Créer une nouvelle réservation
            $reservation = new Reservation();
            $reservation->setNom($nom);
            $reservation->setEmail($email);
            $reservation->setTelephone($telephone);
            $reservation->setNbPersonnes($nb_personnes);
            $reservation->setDateReservation($date_reservation);
            $reservation->setMidi($midi);
            $reservation->setSoir($soir);

            //Enregistrer la réservation
            $reservation_id = $this->reservation_repository->EnregistrementReservation($reservation);

            if ($reservation_id !== false) {
                //Succès
                echo json_encode(['success' => true, 'reservation_id' => $reservation_id]);
            } else {
                //Erreur lors de l'enregistrement
                echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement de la réservation.']);
            }
        } else {
            //Champs manquants
            echo json_encode(['success' => false, 'message' => 'Champs requis manquants.']);
        }
    }
}
