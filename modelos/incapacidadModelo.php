<?php
// modelos/incapacidadModelo.php

class IncapacidadModelo {
    private $db;

    public function __construct(PDO $conexion) {
        $this->db = $conexion;
    }

    /**
     * Registra una nueva incapacidad
     */
    public function crearIncapacidad(array $datos) {
        $sql = "INSERT INTO incapacidades (
                    usuario_id, nombre_empleado, cedula, cargo, area,
                    tipo_incapacidad, eps, codigo_cie10, descripcion_diagnostico,
                    fecha_inicio, fecha_fin, dias_incapacidad, es_prorroga,
                    archivo_adjunto, nombre_archivo_original, observaciones_empleado,
                    estado
                ) VALUES (
                    :usuario_id, :nombre_empleado, :cedula, :cargo, :area,
                    :tipo_incapacidad, :eps, :codigo_cie10, :descripcion_diagnostico,
                    :fecha_inicio, :fecha_fin, :dias_incapacidad, :es_prorroga,
                    :archivo_adjunto, :nombre_archivo_original, :observaciones_empleado,
                    'pendiente'
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':usuario_id'               => $datos['usuario_id'],
            ':nombre_empleado'          => $datos['nombre_empleado'],
            ':cedula'                   => $datos['cedula'],
            ':cargo'                    => $datos['cargo'],
            ':area'                     => $datos['area'],
            ':tipo_incapacidad'         => $datos['tipo_incapacidad'] ?? 'Enfermedad General',
            ':eps'                      => $datos['eps'],
            ':codigo_cie10'             => !empty($datos['codigo_cie10']) ? trim($datos['codigo_cie10']) : null,
            ':descripcion_diagnostico'  => !empty($datos['descripcion_diagnostico']) ? trim($datos['descripcion_diagnostico']) : null,
            ':fecha_inicio'             => $datos['fecha_inicio'],
            ':fecha_fin'                => $datos['fecha_fin'],
            ':dias_incapacidad'         => (int)($datos['dias_incapacidad'] ?? 1),
            ':es_prorroga'              => ($datos['es_prorroga'] ?? 'no') === 'si' ? 'si' : 'no',
            ':archivo_adjunto'          => $datos['archivo_adjunto'] ?? null,
            ':nombre_archivo_original'  => $datos['nombre_archivo_original'] ?? null,
            ':observaciones_empleado'   => !empty($datos['observaciones_empleado']) ? trim($datos['observaciones_empleado']) : null
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Obtiene una incapacidad por ID
     */
    public function obtenerIncapacidadPorId(int $id) {
        $sql = "SELECT i.*, u.email as email_empleado, u.usuario as username
                FROM incapacidades i
                LEFT JOIN usuarios u ON i.usuario_id = u.usuario_id
                WHERE i.id = :id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene el listado de incapacidades de un empleado específico
     */
    public function obtenerIncapacidadesPorUsuario(int $usuario_id) {
        $sql = "SELECT * FROM incapacidades
                WHERE usuario_id = :usuario_id
                ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todas las incapacidades registradas (para Camila / Gestión Humana / SuperUsuario)
     */
    public function obtenerTodasLasIncapacidades(?string $estado = null, ?string $busqueda = null, ?string $eps = null) {
        $sql = "SELECT i.*, u.email as email_empleado
                FROM incapacidades i
                LEFT JOIN usuarios u ON i.usuario_id = u.usuario_id
                WHERE 1=1";
        
        $params = [];

        if (!empty($estado) && $estado !== 'todos') {
            $sql .= " AND i.estado = :estado";
            $params[':estado'] = $estado;
        }

        if (!empty($eps) && $eps !== 'todas') {
            $sql .= " AND i.eps = :eps";
            $params[':eps'] = $eps;
        }

        if (!empty($busqueda)) {
            $sql .= " AND (i.nombre_empleado LIKE :busq OR i.cedula LIKE :busq OR i.codigo_cie10 LIKE :busq OR i.tipo_incapacidad LIKE :busq)";
            $params[':busq'] = "%$busqueda%";
        }

        $sql .= " ORDER BY i.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza la gestión realizada por Talento Humano / Camila
     */
    public function actualizarGestionRH(int $id, string $estado, int $revisorId, string $nombreRevisor, ?string $observacionesRH) {
        $sql = "UPDATE incapacidades SET
                    estado = :estado,
                    revisado_por_id = :revisado_por_id,
                    nombre_revisor = :nombre_revisor,
                    fecha_revision = NOW(),
                    observaciones_rh = :observaciones_rh
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id'               => $id,
            ':estado'           => $estado,
            ':revisado_por_id'  => $revisorId,
            ':nombre_revisor'   => $nombreRevisor,
            ':observaciones_rh' => !empty($observacionesRH) ? trim($observacionesRH) : null
        ]);
    }

    /**
     * Estadísticas globales de incapacidades para paneles y KPIs
     */
    public function obtenerEstadisticas() {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                    SUM(CASE WHEN estado = 'aprobada' THEN 1 ELSE 0 END) as aprobadas,
                    SUM(CASE WHEN estado = 'validada_eps' THEN 1 ELSE 0 END) as validadas_eps,
                    SUM(CASE WHEN estado = 'rechazada' THEN 1 ELSE 0 END) as rechazadas,
                    COALESCE(SUM(dias_incapacidad), 0) as total_dias
                FROM incapacidades";

        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Estadísticas para un empleado en particular
     */
    public function obtenerEstadisticasEmpleado(int $usuario_id) {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                    SUM(CASE WHEN estado IN ('aprobada', 'validada_eps') THEN 1 ELSE 0 END) as aprobadas,
                    COALESCE(SUM(dias_incapacidad), 0) as total_dias
                FROM incapacidades
                WHERE usuario_id = :usuario_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Eliminar incapacidad (solo si está pendiente o si es administrador)
     */
    public function eliminarIncapacidad(int $id, int $usuario_id, bool $esAdmin = false) {
        // Obtener el registro para borrar el archivo físico adjunto
        $item = $this->obtenerIncapacidadPorId($id);

        if ($esAdmin) {
            $sql = "DELETE FROM incapacidades WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $res = $stmt->execute([':id' => $id]);
        } else {
            $sql = "DELETE FROM incapacidades WHERE id = :id AND usuario_id = :usuario_id AND estado = 'pendiente'";
            $stmt = $this->db->prepare($sql);
            $res = $stmt->execute([':id' => $id, ':usuario_id' => $usuario_id]);
        }

        if ($res && $item && !empty($item['archivo_adjunto'])) {
            $rutaArchivo = __DIR__ . '/../' . ltrim($item['archivo_adjunto'], '/');
            if (file_exists($rutaArchivo)) {
                @unlink($rutaArchivo);
            }
        }

        return $res;
    }
}
