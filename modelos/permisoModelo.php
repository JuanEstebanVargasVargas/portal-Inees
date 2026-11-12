<?php
// modelos/permisoModelo.php

class PermisoModelo {
    private $db;

    public function __construct(PDO $conexion) {
        $this->db = $conexion;
    }

    /**
     * Registra una nueva solicitud de permiso
     */
    public function crearPermiso(array $datos) {
        $sql = "INSERT INTO solicitudes_permisos (
                    usuario_id, codigo_formato, version_formato, nombre_empleado,
                    cedula, cargo, departamento_area, detalle_permiso, fecha_solicitud,
                    motivo_permiso, fecha_desde, fecha_hasta, hora_desde, hora_hasta,
                    es_remunerado, firma_empleado, estado_general
                ) VALUES (
                    :usuario_id, :codigo_formato, :version_formato, :nombre_empleado,
                    :cedula, :cargo, :departamento_area, :detalle_permiso, :fecha_solicitud,
                    :motivo_permiso, :fecha_desde, :fecha_hasta, :hora_desde, :hora_hasta,
                    :es_remunerado, :firma_empleado, 'pendiente'
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':usuario_id'         => $datos['usuario_id'],
            ':codigo_formato'     => $datos['codigo_formato'] ?? 'GTH-05-01',
            ':version_formato'    => $datos['version_formato'] ?? '1',
            ':nombre_empleado'    => $datos['nombre_empleado'],
            ':cedula'             => $datos['cedula'],
            ':cargo'              => $datos['cargo'],
            ':departamento_area'  => $datos['departamento_area'],
            ':detalle_permiso'    => $datos['detalle_permiso'],
            ':fecha_solicitud'    => $datos['fecha_solicitud'],
            ':motivo_permiso'     => $datos['motivo_permiso'],
            ':fecha_desde'        => $datos['fecha_desde'],
            ':fecha_hasta'        => $datos['fecha_hasta'],
            ':hora_desde'         => !empty($datos['hora_desde']) ? $datos['hora_desde'] : null,
            ':hora_hasta'         => !empty($datos['hora_hasta']) ? $datos['hora_hasta'] : null,
            ':es_remunerado'      => ($datos['es_remunerado'] ?? 'no') === 'si' ? 'si' : 'no',
            ':firma_empleado'     => $datos['firma_empleado'] ?? $datos['nombre_empleado']
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Obtiene una solicitud de permiso específica por ID
     */
    public function obtenerPermisoPorId(int $id) {
        $sql = "SELECT p.*, u.email as email_empleado, u.usuario as username
                FROM solicitudes_permisos p
                LEFT JOIN usuarios u ON p.usuario_id = u.usuario_id
                WHERE p.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todas las solicitudes del usuario actual
     */
    public function obtenerPermisosPorUsuario(int $usuario_id) {
        $sql = "SELECT * FROM solicitudes_permisos
                WHERE usuario_id = :usuario_id
                ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todas las solicitudes del sistema (para SuperUsuario y Gestión Humana)
     */
    public function obtenerTodosLosPermisos() {
        $sql = "SELECT p.*, u.email as email_empleado
                FROM solicitudes_permisos p
                LEFT JOIN usuarios u ON p.usuario_id = u.usuario_id
                ORDER BY p.id DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza la decisión del Jefe Inmediato
     */
    public function actualizarAprobacionJefe(int $id, string $estadoJefe, ?string $nombreJefe, ?string $observaciones, ?string $fechaFirma) {
        $estadoGeneral = ($estadoJefe === 'aprobado') ? 'aprobado' : (($estadoJefe === 'no_aprueba') ? 'rechazado' : 'pendiente');

        $sql = "UPDATE solicitudes_permisos SET
                    estado_jefe = :estado_jefe,
                    jefe_nombre = :jefe_nombre,
                    observaciones_jefe = :observaciones_jefe,
                    fecha_firma_jefe = :fecha_firma_jefe,
                    estado_general = :estado_general
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'                 => $id,
            ':estado_jefe'        => $estadoJefe,
            ':jefe_nombre'        => $nombreJefe,
            ':observaciones_jefe' => $observaciones,
            ':fecha_firma_jefe'   => $fechaFirma ?: date('Y-m-d'),
            ':estado_general'     => $estadoGeneral
        ]);
    }

    /**
     * Actualiza la sección de Recursos Humanos / Gestión de Talento Humano
     */
    public function actualizarGestionHumana(int $id, string $estadoRH, ?string $recibidoPor, ?string $fechaRegistro, ?string $observacionesRH) {
        $sql = "UPDATE solicitudes_permisos SET
                    estado_rh = :estado_rh,
                    recibido_por_rh = :recibido_por_rh,
                    fecha_registro_rh = :fecha_registro_rh,
                    observaciones_rh = :observaciones_rh
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'                => $id,
            ':estado_rh'         => $estadoRH,
            ':recibido_por_rh'   => $recibidoPor,
            ':fecha_registro_rh' => $fechaRegistro ?: date('Y-m-d'),
            ':observaciones_rh'  => $observacionesRH
        ]);
    }

    /**
     * Elimina una solicitud si aún está pendiente o si es administrador
     */
    public function eliminarPermiso(int $id, int $usuario_id, bool $esAdmin = false) {
        if ($esAdmin) {
            $sql = "DELETE FROM solicitudes_permisos WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } else {
            $sql = "DELETE FROM solicitudes_permisos WHERE id = :id AND usuario_id = :usuario_id AND estado_general = 'pendiente'";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id, ':usuario_id' => $usuario_id]);
        }
    }
}
