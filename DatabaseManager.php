<?php

class DatabaseManager
{
    protected static ?PDO $pdo = null;

    public static function getConnexion()
    {
        if (self::$pdo == null) {
            //Créer connexion
            self::$pdo = self::connectDB();
        }

        return self::$pdo;
    }

    protected static function connectDB(): PDO
    {

        $host = 'localhost';
        $dbName = 'garage12';
        $user = 'root';
        $password = '';

        try {
            $pdo = new PDO('mysql:host=' . $host . ';dbname=' . $dbName . ';charset=utf8', $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $pdo;
        } catch (Exception $e) {
            echo ("Erreur de connexion a la base de données. connectDB()");
            die();
        }
    }
}
