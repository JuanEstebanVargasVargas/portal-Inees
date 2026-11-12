<?php
// modelos/vacacionModelo.php

class VacacionModelo {
    private $db;

    public function __construct(PDO $conexion) {
        $this->db = $conexion;
    }

    /**
     * Registra una nueva solicitud de vacaciones
     */
    public function crearSolicitud(array $datos): int {
        $sql = "INSERT INTO solicitudes_vacaciones (
                    usuario_id, nombre_empleado, cedula, cargo, area,
                    fecha_inicio, fecha_fin, fecha_reincorporacion, dias_solicitados,
                    periodo_causado, archivo_carta, nombre_archivo_original, observaciones, estado
                ) VALUES (
                    :usuario_id, :nombre_empleado, :cedula, :cargo, :area,
                    :fecha_inicio, :fecha_fin, :fecha_reincorporacion, :dias_solicitados,
                    :periodo_causado, :archivo_carta, :nombre_archivo_original, :observaciones, 'pendiente'
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':usuario_id'              => $datos['usuario_id'],
            ':nombre_empleado'         => $datos['nombre_empleado'],
            ':cedula'                  => $datos['cedula'],
            ':cargo'                   => $datos['cargo'],
            ':area'                    => $datos['area'],
            ':fecha_inicio'            => $datos['fecha_inicio'],
            ':fecha_fin'               => $datos['fecha_fin'],
            ':fecha_reincorporacion'   => !empty($datos['fecha_reincorporacion']) ? $datos['fecha_reincorporacion'] : null,
            ':dias_solicitados'        => (int)($datos['dias_solicitados'] ?? 1),
            ':periodo_causado'         => !empty($datos['periodo_causado']) ? trim($datos['periodo_causado']) : null,
            ':archivo_carta'           => $datos['archivo_carta'],
            ':nombre_archivo_original' => $datos['nombre_archivo_original'] ?? null,
            ':observaciones'           => !empty($datos['observaciones']) ? trim($datos['observaciones']) : null,
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Solicitudes de un empleado específico
     */
    public function obtenerSolicitudesPorUsuario(int $usuario_id): array {
        $sql = "SELECT * FROM solicitudes_vacaciones
                WHERE usuario_id = :usuario_id
                ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Todas las solicitudes (Gestión Humana / SuperUsuario) con filtros opcionales
     */
    public function obtenerTodasLasSolicitudes(?string $estado = null, ?string $busqueda = null): array {
        $sql = "SELECT s.*, u.email AS email_empleado
                FROM solicitudes_vacaciones s
                LEFT JOIN usuarios u ON s.usuario_id = u.usuario_id
                WHERE 1=1";
        $params = [];

        if (!empty($estado) && $estado !== 'todos') {
            $sql .= " AND s.estado = :estado";
            $params[':estado'] = $estado;
        }

        if (!empty($busqueda)) {
            $sql .= " AND (s.nombre_empleado LIKE :busqueda OR s.cedula LIKE :busqueda OR s.area LIKE :busqueda OR s.cargo LIKE :busqueda)";
            $params[':busqueda'] = '%' . $busqueda . '%';
        }

        $sql .= " ORDER BY s.id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una solicitud por ID
     */
    public function obtenerSolicitudPorId(int $id): ?array {
        $sql = "SELECT s.*, u.email AS email_empleado
                FROM solicitudes_vacaciones s
                LEFT JOIN usuarios u ON s.usuario_id = u.usuario_id
                WHERE s.id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Aprobar o rechazar una solicitud (Gestión Humana / SuperUsuario)
     */
    public function gestionarSolicitud(int $id, string $estado, int $revisorId, string $revisorNombre, ?string $obs): bool {
        $sql = "UPDATE solicitudes_vacaciones
                SET estado = :estado,
                    revisado_por_id = :revisor_id,
                    nombre_revisor  = :revisor_nombre,
                    fecha_revision  = NOW(),
                    observaciones_rh = :obs
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':estado'         => $estado,
            ':revisor_id'     => $revisorId,
            ':revisor_nombre' => $revisorNombre,
            ':obs'            => $obs,
            ':id'             => $id,
        ]);
    }

    /**
     * Elimina una solicitud (solo si está pendiente, o si es admin)
     */
    public function eliminarSolicitud(int $id, int $usuario_id, bool $esAdmin): bool {
        if ($esAdmin) {
            $sql = "DELETE FROM solicitudes_vacaciones WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } else {
            $sql = "DELETE FROM solicitudes_vacaciones WHERE id = :id AND usuario_id = :uid AND estado = 'pendiente'";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':id' => $id, ':uid' => $usuario_id]);
        }
    }

    /**
     * Conteo por estado (para estadísticas)
     */
    public function contarPorEstado(): array {
        $sql = "SELECT estado, COUNT(*) as total FROM solicitudes_vacaciones GROUP BY estado";
        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = ['pendiente' => 0, 'aprobada' => 0, 'rechazada' => 0];
        foreach ($rows as $r) {
            $result[$r['estado']] = (int)$r['total'];
        }
        return $result;
    }
}
