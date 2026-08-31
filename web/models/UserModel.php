<?php

# MODELO QUE GESTIONA EL REGISTRO Y LOGIN DE USUARIOS
# TRABAJA CON LAS TABLAS 'users_data' Y 'users_login'

require_once __DIR__ . '/Connection.php';

class UserModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::obtener();
    }
    # MÉTODO PARA REGISTRAR UN NUEVO USUARIO
    public function registrar(array $datos): bool
    {
        try {
            $this->pdo->beginTransaction();

           
            $sqlData = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) 
                        VALUES (:nombre, :apellidos, :email, :telefono, :fecha_nacimiento, :direccion, :sexo)";
            
            $stmtData = $this->pdo->prepare($sqlData);
            $stmtData->execute([
                'nombre' => $datos['nombre'],
                'apellidos' => $datos['apellidos'],
                'email' => $datos['email'],
                'telefono' => $datos['telefono'],
                'fecha_nacimiento' => $datos['fecha_nacimiento'],
                'direccion' => $datos['direccion'],
                'sexo' => $datos['sexo']
            ]);

            $idUser = $this->pdo->lastInsertId();

            $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);

            $sqlLogin = "INSERT INTO users_login (idUser, usuario, password, rol) 
                         VALUES (:idUser, :usuario, :password, :rol)";
            
            $stmtLogin = $this->pdo->prepare($sqlLogin);
            $stmtLogin->execute([
                'idUser' => $idUser,
                'usuario' => $datos['usuario'],
                'password' => $passwordHash,
                'rol' => 'user' 
            ]);

          
            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            
            $this->pdo->rollBack();
            return false;
        }
    }
# MÉTODO PARA VALIDAR EL LOGIN 
    public function validarLogin(string $usuario, string $password)
    {
        $sql = "SELECT u.idUser, u.nombre, l.password, l.rol 
                FROM users_data u
                JOIN users_login l ON u.idUser = l.idUser
                WHERE BINARY l.usuario = :usuario";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['usuario' => $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user; 
        }

        return false; 
    }
# OBTENER DATOS COMPLETOS DE UN USUARIO POR SU ID (Para el perfil)
    public function obtenerPorId(int $idUser)
    {
        $sql = "SELECT u.*, l.usuario, l.rol 
                FROM users_data u
                JOIN users_login l ON u.idUser = l.idUser
                WHERE u.idUser = :idUser";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['idUser' => $idUser]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    # ACTUALIZAR DATOS PERSONALES Y/O CONTRASEÑA
    public function actualizarPerfil(int $idUser, array $datos): bool
    {
        try {
            $this->pdo->beginTransaction();

            
            $sqlData = "UPDATE users_data 
                        SET nombre = :nombre, apellidos = :apellidos, email = :email, 
                            telefono = :telefono, fecha_nacimiento = :fecha_nacimiento, 
                            direccion = :direccion, sexo = :sexo 
                        WHERE idUser = :idUser";
            
            $stmtData = $this->pdo->prepare($sqlData);
            $stmtData->execute([
                'nombre' => $datos['nombre'],
                'apellidos' => $datos['apellidos'],
                'email' => $datos['email'],
                'telefono' => $datos['telefono'],
                'fecha_nacimiento' => $datos['fecha_nacimiento'],
                'direccion' => $datos['direccion'],
                'sexo' => $datos['sexo'],
                'idUser' => $idUser
            ]);

            
            if (!empty($datos['password'])) {
                $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);
                $sqlLogin = "UPDATE users_login SET password = :password WHERE idUser = :idUser";
                $stmtLogin = $this->pdo->prepare($sqlLogin);
                $stmtLogin->execute([
                    'password' => $passwordHash,
                    'idUser' => $idUser
                ]);
            }

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    # MÉTODO PARA OBTENER TODOS LOS USUARIOS (PARA EL PANEL DE ADMIN)
    public function obtenerTodosLosUsuarios()
    {
        $sql = "SELECT u.idUser, u.nombre, u.apellidos, u.email, l.usuario, l.rol 
                FROM users_data u
                JOIN users_login l ON u.idUser = l.idUser";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    # MÉTODO PARA ELIMINAR UN USUARIO (BORRA DE AMBAS TABLAS USANDO TRANSACCIÓN)
    public function eliminarUsuario(int $idUser): bool
    {
        try {
            $this->pdo->beginTransaction();

            # 1. Borrar primero de users_login (por la restricción de clave foránea)
            $stmtLogin = $this->pdo->prepare("DELETE FROM users_login WHERE idUser = :idUser AND rol != 'admin'");
            $stmtLogin->execute(['idUser' => $idUser]);

            # 2. Borrar de users_data
            $stmtData = $this->pdo->prepare("DELETE FROM users_data WHERE idUser = :idUser");
            $stmtData->execute(['idUser' => $idUser]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    # MÉTODO PARA CREAR USUARIO DESDE EL PANEL DE ADMINISTRACIÓN (Con rol personalizable)
    public function crearUsuarioAdmin(array $datos): bool
    {
        try {
            $this->pdo->beginTransaction();

            $sqlData = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) 
                        VALUES (:nombre, :apellidos, :email, :telefono, :fecha_nacimiento, :direccion, :sexo)";
            
            $stmtData = $this->pdo->prepare($sqlData);
            $stmtData->execute([
                'nombre' => $datos['nombre'],
                'apellidos' => $datos['apellidos'],
                'email' => $datos['email'],
                'telefono' => $datos['telefono'],
                'fecha_nacimiento' => $datos['fecha_nacimiento'],
                'direccion' => $datos['direccion'],
                'sexo' => $datos['sexo']
            ]);

            $idUser = $this->pdo->lastInsertId();
            $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);

            $sqlLogin = "INSERT INTO users_login (idUser, usuario, password, rol) 
                         VALUES (:idUser, :usuario, :password, :rol)";
            
            $stmtLogin = $this->pdo->prepare($sqlLogin);
            $stmtLogin->execute([
                'idUser' => $idUser,
                'usuario' => $datos['usuario'],
                'password' => $passwordHash,
                'rol' => $datos['rol'] # Puede ser 'user' o 'admin'
            ]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    # MÉTODO PARA ACTUALIZAR USUARIO DESDE EL PANEL DE ADMIN
    public function actualizarUsuarioAdmin(int $idUser, array $datos): bool
    {
        try {
            $this->pdo->beginTransaction();

            # 1. Actualizar datos personales
            $sqlData = "UPDATE users_data 
                        SET nombre = :nombre, apellidos = :apellidos, email = :email, 
                            telefono = :telefono, fecha_nacimiento = :fecha_nacimiento, 
                            direccion = :direccion, sexo = :sexo 
                        WHERE idUser = :idUser";
            
            $stmtData = $this->pdo->prepare($sqlData);
            $stmtData->execute([
                'nombre' => $datos['nombre'],
                'apellidos' => $datos['apellidos'],
                'email' => $datos['email'],
                'telefono' => $datos['telefono'],
                'fecha_nacimiento' => $datos['fecha_nacimiento'],
                'direccion' => $datos['direccion'],
                'sexo' => $datos['sexo'],
                'idUser' => $idUser
            ]);

            # 2. Actualizar rol (y contraseña solo si se introduce una nueva)
            if (!empty($datos['password'])) {
                $passwordHash = password_hash($datos['password'], PASSWORD_DEFAULT);
                $sqlLogin = "UPDATE users_login SET usuario = :usuario, password = :password, rol = :rol WHERE idUser = :idUser";
                $stmtLogin = $this->pdo->prepare($sqlLogin);
                $stmtLogin->execute([
                    'usuario' => $datos['usuario'],
                    'password' => $passwordHash,
                    'rol' => $datos['rol'],
                    'idUser' => $idUser
                ]);
            } else {
                $sqlLogin = "UPDATE users_login SET usuario = :usuario, rol = :rol WHERE idUser = :idUser";
                $stmtLogin = $this->pdo->prepare($sqlLogin);
                $stmtLogin->execute([
                    'usuario' => $datos['usuario'],
                    'rol' => $datos['rol'],
                    'idUser' => $idUser
                ]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}
?>