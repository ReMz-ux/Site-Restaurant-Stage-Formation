<?php

class Tools
{
    /**
     * Méthode pour sanitize les chaines de caractères
     * @param string $str Chaine à nettoyer
     * @return string chaine nettoyé
     */
    public static function sanitize(string $str): string
    {
        $str = trim($str);
        $str = strip_tags($str);
        $str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        return $str;
    }

    public static function sanitizeString(?string $str): ?string
    {
        if ($str === null) {
            return null;
        }
        return self::sanitize($str);
    }

    public static function sanitizeInt($val): ?int
    {
        if ($val === null || $val === '') {
            return null;
        }
        $num = filter_var($val, FILTER_SANITIZE_NUMBER_INT);
        if ($num === false || $num === '') {
            return null;
        }
        return (int)$num;
    }

    public static function sanitizeEmail(?string $email): ?string
    {
        if (empty($email)) {
            return null;
        }
        $email = trim($email);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;
    }

    public static function sanitizePhone(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }
        $phone = trim($phone);
        // conserver chiffres, plus, espaces, parenthèses et tirets
        $phone = preg_replace('/[^0-9+\s\-()]/', '', $phone);
        return $phone;
    }

    public static function sanitizeDate(?string $date): ?string
    {
        if (empty($date)) {
            return null;
        }
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date ? $date : null;
    }

    public static function sanitizeTime(?string $time): ?string
    {
        if (empty($time)) {
            return null;
        }
        $t = \DateTime::createFromFormat('H:i:s', $time);
        return $t && $t->format('H:i:s') === $time ? $time : null;
    }

    /**
     * Nettoie un tableau de données attendu pour une réservation.
     * Retourne un tableau avec les mêmes clés :
     * id_reservation, nom, email, telephone, nb_personnes, date_reservation, midi, soir
     * Les valeurs invalides sont retournées à `null`.
     *
     * @param array $data
     * @return array
     */
    public static function sanitizeReservation(array $data): array
    {
        $clean = [];
        $clean['id_reservation'] = self::sanitizeInt($data['id_reservation'] ?? null);
        $clean['nom'] = self::sanitizeString($data['nom'] ?? null);
        $clean['email'] = self::sanitizeEmail($data['email'] ?? null);
        $clean['telephone'] = self::sanitizePhone($data['telephone'] ?? null);
        $clean['nb_personnes'] = self::sanitizeInt($data['nb_personnes'] ?? null);
        $clean['date_reservation'] = self::sanitizeDate($data['date_reservation'] ?? null);
        $clean['midi'] = self::sanitizeTime($data['midi'] ?? null);
        $clean['soir'] = self::sanitizeTime($data['soir'] ?? null);
        return $clean;
    }

    /**
     * Méthode qui retourne l'extension d'un fichier
     * @param string $file nom du fichier
     * @return string extension du fichier
     */
    public static function getFileExtension($file)
    {
        return substr(strrchr($file, '.'), 1);
    }
}
