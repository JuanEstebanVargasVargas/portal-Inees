<?php
// modelos/loginModelo.php

class LoginModelo {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    /**
     * Busca un usuario activo por su nombre de usuario o por email
     */
    public function obtenerUsuario($identificador) {
        $sql = "SELECT u.usuario_id, u.nombre, u.cedula, u.cargo, u.area, 
                       u.email, u.usuario, u.password_hash, u.forzar_cambio_pwd, 
                       u.nivel_acceso, u.estado, u.foto_perfil, t.nombreTipoUsuario AS rol_nombre
                FROM usuarios u
                LEFT JOIN tipousuario t ON u.nivel_acceso = t.idTipoUsuario
                WHERE (u.usuario = :identificador OR u.email = :identificador)
                  AND u.estado = 'activo'
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':identificador', $identificador, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Registra el historial de acceso en la tabla 'login' y actualiza 'ultimo_acceso'
     */
    public function registrarAcceso($usuario_id, $usuario, $ip) {
        try {
            // 1. Guardar en tabla login
            $sqlLogin = "INSERT INTO login (usuario_id, fecha, hora, usuario, ip) 
                         VALUES (:usuario_id, CURDATE(), CURTIME(), :usuario, :ip)";
            $stmtLogin = $this->db->prepare($sqlLogin);
            $stmtLogin->execute([
                ':usuario_id' => $usuario_id,
                ':usuario'    => $usuario,
                ':ip'         => $ip
            ]);

            // 2. Actualizar último acceso en tabla usuarios
            $sqlUser = "UPDATE usuarios SET ultimo_acceso = NOW() WHERE usuario_id = :usuario_id";
            $stmtUser = $this->db->prepare($sqlUser);
            $stmtUser->execute([':usuario_id' => $usuario_id]);
        } catch (Exception $e) {
            // Error silencioso en el log de auditoría para no bloquear el login
        }
    }
}
