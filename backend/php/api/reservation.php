<?php
require_once __DIR__ . '/../db_connect.php';
require_once __DIR__ . '/../repositories/ReservationRepository.php';
require_once __DIR__ . '/../controller/ReservationController.php';

$repo = new ReservationRepository($connexion);
$controller = new ReservationController($repo);
$controller->createReservation();
