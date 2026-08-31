<?php

# MODELO QUE GESTIONA LAS OPERACIONES SOBRE LA TABLA 'noticias'
# OBTIENE LA CONEXIÓN A TRAVÉS DE LA CLASE Connection

require_once __DIR__ . '/Connection.php';

class NoticiaModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::obtener();
    }

    public function obtenerTodas(): array
    {
        $sql = "SELECT noticias.*, users_data.nombre AS autor_nombre 
                FROM noticias 
                JOIN users_data ON noticias.idUser = users_data.idUser 
                ORDER BY noticias.fecha DESC";
                
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

# OBTENER UNA NOTICIA POR SU ID CON EL AUTOR
    public function obtenerPorId(int $idNoticia)
    {
        $sql = "SELECT noticias.*, users_data.nombre AS autor_nombre 
                FROM noticias 
                JOIN users_data ON noticias.idUser = users_data.idUser 
                WHERE noticias.idNoticia = :idNoticia";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['idNoticia' => $idNoticia]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    # CREAR NUEVA NOTICIA
    public function crear(string $titulo, string $texto, string $imagen, int $idUser): bool
    {
        $sql = "INSERT INTO noticias (titulo, texto, imagen, idUser, fecha) VALUES (:titulo, :texto, :imagen, :idUser, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'titulo' => $titulo,
            'texto' => $texto,
            'imagen' => $imagen,
            'idUser' => $idUser
        ]);
    }

    # ACTUALIZAR NOTICIA
    public function actualizar(int $idNoticia, string $titulo, string $texto, string $imagen): bool
    {
        $sql = "UPDATE noticias SET titulo = :titulo, texto = :texto, imagen = :imagen WHERE idNoticia = :idNoticia";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'titulo' => $titulo,
            'texto' => $texto,
            'imagen' => $imagen,
            'idNoticia' => $idNoticia
        ]);
    }

    # BORRAR NOTICIA
    public function borrar(int $idNoticia): bool
    {
        $sql = "DELETE FROM noticias WHERE idNoticia = :idNoticia";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['idNoticia' => $idNoticia]);
    }
}
?>