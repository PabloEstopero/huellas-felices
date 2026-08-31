<?php
require_once __DIR__ . '/Connection.php'; 

class CitaModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Connection::obtener();
    }

    # OBTENER TODAS LAS CITAS DE UN USUARIO
    public function obtenerCitasPorUsuario(int $idUser): array
    {
        $sql = "SELECT * FROM citas WHERE idUser = :idUser ORDER BY fecha_cita ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['idUser' => $idUser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    # OBTENER UNA CITA POR SU ID 
    public function obtenerCitaPorId(int $idCita)
    {
        $sql = "SELECT * FROM citas WHERE idCita = :idCita";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['idCita' => $idCita]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    # CREAR NUEVA CITA
    public function crearCita(int $idUser, string $fechaCita, string $motivoCita): bool
    {
        $sql = "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES (:idUser, :fecha_cita, :motivo_cita)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'idUser' => $idUser,
            'fecha_cita' => $fechaCita,
            'motivo_cita' => $motivoCita
        ]);
    }

    # MODIFICAR CITA 
    public function actualizarCita(int $idCita, int $idUser, string $fechaCita, string $motivoCita): bool
    {
        
        $cita = $this->obtenerCitaPorId($idCita);
        if (!$cita || intval($cita['idUser']) !== intval($idUser)) {
            return false;
        }

        if ($fechaCita < date('Y-m-d')) {
            return false; 
        }

        $sql = "UPDATE citas SET fecha_cita = :fecha_cita, motivo_cita = :motivo_cita WHERE idCita = :idCita AND idUser = :idUser";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'fecha_cita' => $fechaCita,
            'motivo_cita' => $motivoCita,
            'idCita' => $idCita,
            'idUser' => $idUser
        ]);
    }

    # BORRAR CITA 
    public function borrarCita(int $idCita, int $idUser): bool
    {
        $cita = $this->obtenerCitaPorId($idCita);
        if (!$cita || intval($cita['idUser']) !== intval($idUser)) {
            return false;
        }

        if ($cita['fecha_cita'] < date('Y-m-d')) {
            return false; 
        }

        $sql = "DELETE FROM citas WHERE idCita = :idCita AND idUser = :idUser";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'idCita' => $idCita,
            'idUser' => $idUser
        ]);
    }
    # --- MÉTODOS PARA EL PANEL DE ADMINISTRACIÓN ---

    # CREAR CITA PARA CUALQUIER USUARIO (Admin)
    public function crearCitaAdmin(int $idUser, string $fechaCita, string $motivoCita): bool
    {
        $sql = "INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES (:idUser, :fecha_cita, :motivo_cita)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'idUser' => $idUser,
            'fecha_cita' => $fechaCita,
            'motivo_cita' => $motivoCita
        ]);
    }

    # ACTUALIZAR CITA PARA CUALQUIER USUARIO (Admin)
    public function actualizarCitaAdmin(int $idCita, string $fechaCita, string $motivoCita): bool
    {
        if ($fechaCita < date('Y-m-d')) {
            return false; 
        }

        $sql = "UPDATE citas SET fecha_cita = :fecha_cita, motivo_cita = :motivo_cita WHERE idCita = :idCita";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'fecha_cita' => $fechaCita,
            'motivo_cita' => $motivoCita,
            'idCita' => $idCita
        ]);
    }

    # BORRAR CITA PARA CUALQUIER USUARIO (Admin)
    public function borrarCitaAdmin(int $idCita): bool
    {
        $sql = "DELETE FROM citas WHERE idCita = :idCita";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['idCita' => $idCita]);
    }
}