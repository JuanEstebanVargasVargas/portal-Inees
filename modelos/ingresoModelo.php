<?php
// modelos/ingresoModelo.php

class IngresoModelo {
    private $db;

    public function __construct(PDO $conexion) {
        $this->db = $conexion;
    }

    /**
     * Inserta una nueva solicitud de ingreso
     */
    public function crearSolicitud(array $datos) {
        $sql = "INSERT INTO solicitudes_ingreso (
                    solicitante_id, nombre_solicitante, nombre_candidato, tipo_documento,
                    cedula, fecha_nacimiento, direccion, ciudad, celular, email_candidato,
                    cargo, area, sede, tipo_contrato, salario, fecha_ingreso,
                    horario_trabajo, jefe_inmediato, requiere_computador, tipo_computador,
                    requiere_correo, requiere_celular_corp, requiere_dotacion, tallas_dotacion,
                    areas_notificadas, correos_notificados, observaciones, correo_bienvenida_enviado,
                    fecha_envio_correos, estado
                ) VALUES (
                    :solicitante_id, :nombre_solicitante, :nombre_candidato, :tipo_documento,
                    :cedula, :fecha_nacimiento, :direccion, :ciudad, :celular, :email_candidato,
                    :cargo, :area, :sede, :tipo_contrato, :salario, :fecha_ingreso,
                    :horario_trabajo, :jefe_inmediato, :requiere_computador, :tipo_computador,
                    :requiere_correo, :requiere_celular_corp, :requiere_dotacion, :tallas_dotacion,
                    :areas_notificadas, :correos_notificados, :observaciones, 'si',
                    NOW(), 'en_proceso'
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':solicitante_id'          => $datos['solicitante_id'],
            ':nombre_solicitante'       => $datos['nombre_solicitante'],
            ':nombre_candidato'         => $datos['nombre_candidato'],
            ':tipo_documento'           => $datos['tipo_documento'] ?? 'C.C.',
            ':cedula'                   => $datos['cedula'],
            ':fecha_nacimiento'         => !empty($datos['fecha_nacimiento']) ? $datos['fecha_nacimiento'] : null,
            ':direccion'                => !empty($datos['direccion']) ? trim($datos['direccion']) : null,
            ':ciudad'                   => !empty($datos['ciudad']) ? trim($datos['ciudad']) : 'Bogotá',
            ':celular'                  => $datos['celular'],
            ':email_candidato'          => $datos['email_candidato'],
            ':cargo'                    => $datos['cargo'],
            ':area'                     => $datos['area'],
            ':sede'                     => !empty($datos['sede']) ? trim($datos['sede']) : 'Sede Principal',
            ':tipo_contrato'            => $datos['tipo_contrato'],
            ':salario'                  => !empty($datos['salario']) ? trim($datos['salario']) : null,
            ':fecha_ingreso'            => $datos['fecha_ingreso'],
            ':horario_trabajo'          => !empty($datos['horario_trabajo']) ? trim($datos['horario_trabajo']) : 'Lunes a Viernes 7:30 am - 5:30 pm',
            ':jefe_inmediato'           => !empty($datos['jefe_inmediato']) ? trim($datos['jefe_inmediato']) : null,
            ':requiere_computador'      => ($datos['requiere_computador'] ?? 'no') === 'si' ? 'si' : 'no',
            ':tipo_computador'          => !empty($datos['tipo_computador']) ? trim($datos['tipo_computador']) : null,
            ':requiere_correo'          => ($datos['requiere_correo'] ?? 'no') === 'si' ? 'si' : 'no',
            ':requiere_celular_corp'    => ($datos['requiere_celular_corp'] ?? 'no') === 'si' ? 'si' : 'no',
            ':requiere_dotacion'        => ($datos['requiere_dotacion'] ?? 'no') === 'si' ? 'si' : 'no',
            ':tallas_dotacion'          => !empty($datos['tallas_dotacion']) ? trim($datos['tallas_dotacion']) : null,
            ':areas_notificadas'        => $datos['areas_notificadas'] ?? null,
            ':correos_notificados'      => $datos['correos_notificados'] ?? null,
            ':observaciones'            => !empty($datos['observaciones']) ? trim($datos['observaciones']) : null
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Obtiene el listado de solicitudes de ingreso
     */
    public function obtenerSolicitudes(?string $busqueda = null, ?string $estado = null) {
        $sql = "SELECT * FROM solicitudes_ingreso WHERE 1=1";
        $params = [];

        if (!empty($busqueda)) {
            $sql .= " AND (nombre_candidato LIKE :busq OR cedula LIKE :busq OR cargo LIKE :busq OR area LIKE :busq)";
            $params[':busq'] = "%$busqueda%";
        }

        if (!empty($estado) && $estado !== 'todos') {
            $sql .= " AND estado = :estado";
            $params[':estado'] = $estado;
        }

        $sql .= " ORDER BY id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una solicitud por ID
     */
    public function obtenerSolicitudPorId(int $id) {
        $sql = "SELECT * FROM solicitudes_ingreso WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Actualiza el estado de una solicitud
     */
    public function actualizarEstado(int $id, string $estado) {
        $sql = "UPDATE solicitudes_ingreso SET estado = :estado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':estado' => $estado, ':id' => $id]);
    }

    /**
     * Estadísticas rápidas
     */
    public function obtenerEstadisticas() {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN estado = 'en_proceso' THEN 1 ELSE 0 END) as en_proceso,
                    SUM(CASE WHEN estado = 'contratado' THEN 1 ELSE 0 END) as contratados,
                    SUM(CASE WHEN fecha_ingreso >= CURDATE() THEN 1 ELSE 0 END) as proximos_ingresos
                FROM solicitudes_ingreso";
        return $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
}
