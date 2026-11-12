<?php
// modelos/directorioModelo.php

class DirectorioModelo {
    private $db;

    public function __construct(PDO $conexion) {
        $this->db = $conexion;
    }

    /**
     * Obtiene la lista completa de empleados/usuarios para el directorio
     */
    public function obtenerEmpleados(?string $busqueda = null, ?string $area = null, ?string $estado = null) {
        $sql = "SELECT u.usuario_id, u.nombre, u.cedula, u.cargo, u.area, 
                       u.email, u.celular, u.telefono_corporativo, u.usuario, 
                       u.nivel_acceso, u.ultimo_acceso, u.estado, u.foto_perfil,
                       COALESCE(t.nombreTipoUsuario, 'Empleado') AS rol_nombre
                FROM usuarios u
                LEFT JOIN tipousuario t ON u.nivel_acceso = t.idTipoUsuario
                WHERE 1=1";
        
        $params = [];

        if (!empty($busqueda)) {
            $sql .= " AND (u.nombre LIKE :busq OR u.cedula LIKE :busq OR u.email LIKE :busq OR u.usuario LIKE :busq OR u.cargo LIKE :busq)";
            $params[':busq'] = "%$busqueda%";
        }

        if (!empty($area) && $area !== 'todas') {
            $sql .= " AND u.area = :area";
            $params[':area'] = $area;
        }

        if (!empty($estado) && $estado !== 'todos') {
            $sql .= " AND u.estado = :estado";
            $params[':estado'] = $estado;
        }

        $sql .= " ORDER BY u.nombre ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene estadísticas y lista de áreas para filtros
     */
    public function obtenerEstadisticasYAreas() {
        $sqlTotal = "SELECT 
                        COUNT(*) as total,
                        SUM(CASE WHEN estado = 'activo' THEN 1 ELSE 0 END) as activos,
                        SUM(CASE WHEN estado != 'activo' THEN 1 ELSE 0 END) as inactivos,
                        SUM(CASE WHEN celular IS NOT NULL AND TRIM(celular) != '' THEN 1 ELSE 0 END) as con_celular
                     FROM usuarios";
        $stats = $this->db->query($sqlTotal)->fetch(PDO::FETCH_ASSOC);

        $sqlAreas = "SELECT COALESCE(NULLIF(TRIM(area), ''), 'Sin área') as area_nombre, COUNT(*) as cantidad
                     FROM usuarios
                     GROUP BY area_nombre
                     ORDER BY area_nombre ASC";
        $areas = $this->db->query($sqlAreas)->fetchAll(PDO::FETCH_ASSOC);

        return [
            'total'       => (int)($stats['total'] ?? 0),
            'activos'     => (int)($stats['activos'] ?? 0),
            'inactivos'   => (int)($stats['inactivos'] ?? 0),
            'con_celular' => (int)($stats['con_celular'] ?? 0),
            'areas'       => $areas
        ];
    }

    /**
     * Limpia y formatea un número de celular a formato internacional para WhatsApp
     * Ej: "313 5522374" -> "573135522374"
     */
    public static function limpiarNumeroWhatsApp(?string $celular): ?string {
        if (empty($celular)) return null;
        $num = preg_replace('/[^0-9]/', '', $celular);
        if (empty($num)) return null;

        // Celular Colombia estándar (10 dígitos empezando por 3)
        if (strlen($num) === 10 && $num[0] === '3') {
            return '57' . $num;
        }

        // Si ya incluye el 57 y tiene 12 dígitos
        if (strlen($num) === 12 && substr($num, 0, 2) === '57') {
            return $num;
        }

        return $num;
    }

    /** Obtiene un usuario por ID para edición */
    public function obtenerUsuarioPorId(int $id): ?array {
        $stmt = $this->db->prepare(
            "SELECT u.*, COALESCE(t.nombreTipoUsuario,'Empleado') AS rol_nombre
             FROM usuarios u
             LEFT JOIN tipousuario t ON u.nivel_acceso = t.idTipoUsuario
             WHERE u.usuario_id = :id LIMIT 1"
        );
        $stmt->execute([':id' => $id]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        return $r ?: null;
    }

    /** Verifica si un usuario/cédula ya existe (excluyendo el id actual) */
    public function existeUsuario(string $usuario, string $cedula, int $excluirId = 0): array {
        $result = ['usuario' => false, 'cedula' => false];
        $stmtU = $this->db->prepare(
            "SELECT COUNT(*) FROM usuarios WHERE usuario = :u AND usuario_id != :id"
        );
        $stmtU->execute([':u' => $usuario, ':id' => $excluirId]);
        $result['usuario'] = (int)$stmtU->fetchColumn() > 0;

        if (!empty($cedula)) {
            $stmtC = $this->db->prepare(
                "SELECT COUNT(*) FROM usuarios WHERE cedula = :c AND usuario_id != :id"
            );
            $stmtC->execute([':c' => $cedula, ':id' => $excluirId]);
            $result['cedula'] = (int)$stmtC->fetchColumn() > 0;
        }
        return $result;
    }

    /** Obtiene todos los roles disponibles */
    public function obtenerRoles(): array {
        return $this->db->query("SELECT idTipoUsuario, nombreTipoUsuario FROM tipousuario ORDER BY idTipoUsuario")->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Obtiene lista de áreas distintas */
    public function obtenerAreas(): array {
        $rows = $this->db->query(
            "SELECT DISTINCT TRIM(area) as area FROM usuarios WHERE area IS NOT NULL AND TRIM(area) != '' ORDER BY area ASC"
        )->fetchAll(PDO::FETCH_COLUMN);
        return $rows;
    }

    /** Crea un usuario nuevo. Retorna el nuevo usuario_id o false */
    public function crearUsuario(array $data): int|false {
        $stmt = $this->db->prepare(
            "INSERT INTO usuarios (nombre, cedula, cargo, area, email, celular, telefono_corporativo,
                                   telefono_emergencia, usuario, password_hash, forzar_cambio_pwd,
                                   nivel_acceso, estado, foto_perfil)
             VALUES (:nombre, :cedula, :cargo, :area, :email, :celular, :tel_corp,
                     :tel_emerg, :usuario, :pwd, 1, :nivel, :estado, :foto)"
        );
        $ok = $stmt->execute([
            ':nombre'    => $data['nombre'],
            ':cedula'    => $data['cedula'] ?? null,
            ':cargo'     => $data['cargo'] ?? null,
            ':area'      => $data['area'] ?? null,
            ':email'     => $data['email'] ?? null,
            ':celular'   => $data['celular'] ?? null,
            ':tel_corp'  => $data['telefono_corporativo'] ?? null,
            ':tel_emerg' => $data['telefono_emergencia'] ?? null,
            ':usuario'   => $data['usuario'],
            ':pwd'       => $data['password_hash'],
            ':nivel'     => $data['nivel_acceso'],
            ':estado'    => $data['estado'] ?? 'activo',
            ':foto'      => $data['foto_perfil'] ?? null,
        ]);
        return $ok ? (int)$this->db->lastInsertId() : false;
    }

    /** Actualiza datos de un usuario existente */
    public function actualizarUsuario(int $id, array $data): bool {
        $sets = ["nombre=:nombre","cedula=:cedula","cargo=:cargo","area=:area",
                 "email=:email","celular=:celular","telefono_corporativo=:tel_corp",
                 "telefono_emergencia=:tel_emerg","usuario=:usuario",
                 "nivel_acceso=:nivel","estado=:estado"];
        $params = [
            ':nombre'    => $data['nombre'],
            ':cedula'    => $data['cedula'] ?? null,
            ':cargo'     => $data['cargo'] ?? null,
            ':area'      => $data['area'] ?? null,
            ':email'     => $data['email'] ?? null,
            ':celular'   => $data['celular'] ?? null,
            ':tel_corp'  => $data['telefono_corporativo'] ?? null,
            ':tel_emerg' => $data['telefono_emergencia'] ?? null,
            ':usuario'   => $data['usuario'],
            ':nivel'     => $data['nivel_acceso'],
            ':estado'    => $data['estado'],
            ':id'        => $id,
        ];
        if (!empty($data['password_hash'])) {
            $sets[] = "password_hash=:pwd";
            $params[':pwd'] = $data['password_hash'];
            $sets[] = "forzar_cambio_pwd=1";
        }
        if (array_key_exists('foto_perfil', $data)) {
            $sets[] = "foto_perfil=:foto";
            $params[':foto'] = $data['foto_perfil'];
        }
        $sql = "UPDATE usuarios SET " . implode(',', $sets) . " WHERE usuario_id=:id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /** Cambia solo el estado de un usuario */
    public function cambiarEstado(int $id, string $estado): bool {
        $stmt = $this->db->prepare(
            "UPDATE usuarios SET estado=:e WHERE usuario_id=:id LIMIT 1"
        );
        return $stmt->execute([':e' => $estado, ':id' => $id]);
    }

    /** Elimina la foto de perfil de un usuario */
    public function quitarFoto(int $id): bool {
        $stmt = $this->db->prepare(
            "UPDATE usuarios SET foto_perfil=NULL WHERE usuario_id=:id LIMIT 1"
        );
        return $stmt->execute([':id' => $id]);
    }
}
