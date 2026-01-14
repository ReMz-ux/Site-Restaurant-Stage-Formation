<?php

class Reservation
{
    private int $id_reservation;
    private string $nom;
    private string $email;
    private string $telephone;
    private int $nb_personnes;
    private string $date_reservation;
    private string $midi;
    private string $soir;


    public function getIdReservation()
    {
        return $this->id_reservation;
    }

    public function setIdReservation($id_reservation)
    {
        $this->id_reservation = $id_reservation;
    }


    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }


    public function getNbPersonnes()
    {
        return $this->nb_personnes;
    }

    public function setNbPersonnes($nb_personnes)
    {
        $this->nb_personnes = $nb_personnes;
    }


    public function getDateReservation()
    {
        return $this->date_reservation;
    }

    public function setDateReservation($date_reservation)
    {
        $this->date_reservation = $date_reservation;
    }


    public function getMidi()
    {
        return $this->midi;
    }

    public function setMidi($midi)
    {
        $this->midi = $midi;
    }


    public function getSoir()
    {
        return $this->soir;
    }

    public function setSoir($soir)
    {
        $this->soir = $soir;
    }
}
