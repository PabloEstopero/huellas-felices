<?php
# CLASE QUE GESTIONA LA CONEXIÓN A LA BASE DE DATOS

require_once __DIR__ . '/../config/.env.php';

class Connection
{
    private static ?PDO $instancia = null;

    private function __construct() {}

    public static function obtener(): PDO
    {
        if (self::$instancia === null) {
            $dsn = 'mysql:host=' . DB_HOST
                 . ';dbname='    . DB_NAME
                 . ';charset='   . DB_CHARSET;

            self::$instancia = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return self::$instancia;
    }
}
?>