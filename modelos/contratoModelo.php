<?php
// modelos/contratoModelo.php

class ContratoModelo {
    private PDO $db;

    public function __construct(PDO $conexion) {
        $this->db = $conexion;
    }

    /**
     * Registra un nuevo contrato / hoja de vida
     */
    public function crear(array $datos): int {
        $sql = "INSERT INTO contratos_hojas_vida (
                    usuario_id, nombre_completo, cargo, foto, telefono, email, direccion,
                    cedula, fecha_nacimiento, rh, contacto_emergencia_nombre, contacto_emergencia_cel,
                    contacto_emergencia_parentesco, estado_civil, conyuge_nombre, conyuge_cel,
                    num_hijos, eps, arl, caja_compensacion, fondo_pensiones, formacion_academica,
                    experiencia_empresa, experiencia_cargo, documentos_vencimientos, tipo_contrato,
                    fecha_ingreso, salario, banco, tipo_cuenta, num_cuenta, dotacion_datos,
                    estado, creado_por
                ) VALUES (
                    :usuario_id, :nombre_completo, :cargo, :foto, :telefono, :email, :direccion,
                    :cedula, :fecha_nacimiento, :rh, :contacto_emergencia_nombre, :contacto_emergencia_cel,
                    :contacto_emergencia_parentesco, :estado_civil, :conyuge_nombre, :conyuge_cel,
                    :num_hijos, :eps, :arl, :caja_compensacion, :fondo_pensiones, :formacion_academica,
                    :experiencia_empresa, :experiencia_cargo, :documentos_vencimientos, :tipo_contrato,
                    :fecha_ingreso, :salario, :banco, :tipo_cuenta, :num_cuenta, :dotacion_datos,
                    :estado, :creado_por
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':usuario_id'                     => !empty($datos['usuario_id']) ? (int)$datos['usuario_id'] : null,
            ':nombre_completo'                => trim($datos['nombre_completo'] ?? ''),
            ':cargo'                          => trim($datos['cargo'] ?? ''),
            ':foto'                           => !empty($datos['foto']) ? trim($datos['foto']) : null,
            ':telefono'                       => !empty($datos['telefono']) ? trim($datos['telefono']) : null,
            ':email'                          => !empty($datos['email']) ? trim($datos['email']) : null,
            ':direccion'                      => !empty($datos['direccion']) ? trim($datos['direccion']) : null,
            ':cedula'                         => trim($datos['cedula'] ?? ''),
            ':fecha_nacimiento'               => !empty($datos['fecha_nacimiento']) ? trim($datos['fecha_nacimiento']) : null,
            ':rh'                             => !empty($datos['rh']) ? trim($datos['rh']) : null,
            ':contacto_emergencia_nombre'     => !empty($datos['contacto_emergencia_nombre']) ? trim($datos['contacto_emergencia_nombre']) : null,
            ':contacto_emergencia_cel'        => !empty($datos['contacto_emergencia_cel']) ? trim($datos['contacto_emergencia_cel']) : null,
            ':contacto_emergencia_parentesco' => !empty($datos['contacto_emergencia_parentesco']) ? trim($datos['contacto_emergencia_parentesco']) : null,
            ':estado_civil'                   => !empty($datos['estado_civil']) ? trim($datos['estado_civil']) : null,
            ':conyuge_nombre'                 => !empty($datos['conyuge_nombre']) ? trim($datos['conyuge_nombre']) : null,
            ':conyuge_cel'                    => !empty($datos['conyuge_cel']) ? trim($datos['conyuge_cel']) : null,
            ':num_hijos'                      => isset($datos['num_hijos']) ? trim((string)$datos['num_hijos']) : '0',
            ':eps'                            => !empty($datos['eps']) ? trim($datos['eps']) : null,
            ':arl'                            => !empty($datos['arl']) ? trim($datos['arl']) : null,
            ':caja_compensacion'              => !empty($datos['caja_compensacion']) ? trim($datos['caja_compensacion']) : null,
            ':fondo_pensiones'                => !empty($datos['fondo_pensiones']) ? trim($datos['fondo_pensiones']) : null,
            ':formacion_academica'            => !empty($datos['formacion_academica']) ? trim($datos['formacion_academica']) : null,
            ':experiencia_empresa'            => !empty($datos['experiencia_empresa']) ? trim($datos['experiencia_empresa']) : null,
            ':experiencia_cargo'              => !empty($datos['experiencia_cargo']) ? trim($datos['experiencia_cargo']) : null,
            ':documentos_vencimientos'        => !empty($datos['documentos_vencimientos']) ? $datos['documentos_vencimientos'] : null,
            ':tipo_contrato'                  => !empty($datos['tipo_contrato']) ? trim($datos['tipo_contrato']) : null,
            ':fecha_ingreso'                  => !empty($datos['fecha_ingreso']) ? trim($datos['fecha_ingreso']) : null,
            ':salario'                        => !empty($datos['salario']) ? trim($datos['salario']) : null,
            ':banco'                          => !empty($datos['banco']) ? trim($datos['banco']) : null,
            ':tipo_cuenta'                    => !empty($datos['tipo_cuenta']) ? trim($datos['tipo_cuenta']) : null,
            ':num_cuenta'                     => !empty($datos['num_cuenta']) ? trim($datos['num_cuenta']) : null,
            ':dotacion_datos'                 => !empty($datos['dotacion_datos']) ? $datos['dotacion_datos'] : null,
            ':estado'                         => !empty($datos['estado']) ? trim($datos['estado']) : 'activo',
            ':creado_por'                     => !empty($datos['creado_por']) ? (int)$datos['creado_por'] : null,
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Actualiza un contrato / hoja de vida existente
     */
    public function actualizar(int $id, array $datos): bool {
        $campos = [
            'usuario_id'                     => !empty($datos['usuario_id']) ? (int)$datos['usuario_id'] : null,
            'nombre_completo'                => trim($datos['nombre_completo'] ?? ''),
            'cargo'                          => trim($datos['cargo'] ?? ''),
            'telefono'                       => !empty($datos['telefono']) ? trim($datos['telefono']) : null,
            'email'                          => !empty($datos['email']) ? trim($datos['email']) : null,
            'direccion'                      => !empty($datos['direccion']) ? trim($datos['direccion']) : null,
            'cedula'                         => trim($datos['cedula'] ?? ''),
            'fecha_nacimiento'               => !empty($datos['fecha_nacimiento']) ? trim($datos['fecha_nacimiento']) : null,
            'rh'                             => !empty($datos['rh']) ? trim($datos['rh']) : null,
            'contacto_emergencia_nombre'     => !empty($datos['contacto_emergencia_nombre']) ? trim($datos['contacto_emergencia_nombre']) : null,
            'contacto_emergencia_cel'        => !empty($datos['contacto_emergencia_cel']) ? trim($datos['contacto_emergencia_cel']) : null,
            'contacto_emergencia_parentesco' => !empty($datos['contacto_emergencia_parentesco']) ? trim($datos['contacto_emergencia_parentesco']) : null,
            'estado_civil'                   => !empty($datos['estado_civil']) ? trim($datos['estado_civil']) : null,
            'conyuge_nombre'                 => !empty($datos['conyuge_nombre']) ? trim($datos['conyuge_nombre']) : null,
            'conyuge_cel'                    => !empty($datos['conyuge_cel']) ? trim($datos['conyuge_cel']) : null,
            'num_hijos'                      => isset($datos['num_hijos']) ? trim((string)$datos['num_hijos']) : '0',
            'eps'                            => !empty($datos['eps']) ? trim($datos['eps']) : null,
            'arl'                            => !empty($datos['arl']) ? trim($datos['arl']) : null,
            'caja_compensacion'              => !empty($datos['caja_compensacion']) ? trim($datos['caja_compensacion']) : null,
            'fondo_pensiones'                => !empty($datos['fondo_pensiones']) ? trim($datos['fondo_pensiones']) : null,
            'formacion_academica'            => !empty($datos['formacion_academica']) ? trim($datos['formacion_academica']) : null,
            'experiencia_empresa'            => !empty($datos['experiencia_empresa']) ? trim($datos['experiencia_empresa']) : null,
            'experiencia_cargo'              => !empty($datos['experiencia_cargo']) ? trim($datos['experiencia_cargo']) : null,
            'documentos_vencimientos'        => !empty($datos['documentos_vencimientos']) ? $datos['documentos_vencimientos'] : null,
            'tipo_contrato'                  => !empty($datos['tipo_contrato']) ? trim($datos['tipo_contrato']) : null,
            'fecha_ingreso'                  => !empty($datos['fecha_ingreso']) ? trim($datos['fecha_ingreso']) : null,
            'salario'                        => !empty($datos['salario']) ? trim($datos['salario']) : null,
            'banco'                          => !empty($datos['banco']) ? trim($datos['banco']) : null,
            'tipo_cuenta'                    => !empty($datos['tipo_cuenta']) ? trim($datos['tipo_cuenta']) : null,
            'num_cuenta'                     => !empty($datos['num_cuenta']) ? trim($datos['num_cuenta']) : null,
            'dotacion_datos'                 => !empty($datos['dotacion_datos']) ? $datos['dotacion_datos'] : null,
            'estado'                         => !empty($datos['estado']) ? trim($datos['estado']) : 'activo',
        ];

        $setPart = [];
        $params = [':id' => $id];

        foreach ($campos as $col => $val) {
            $setPart[] = "`$col` = :$col";
            $params[":$col"] = $val;
        }

        // Si se envió una nueva foto, actualizarla
        if (!empty($datos['foto'])) {
            $setPart[] = "`foto` = :foto";
            $params[':foto'] = trim($datos['foto']);
        }

        $sql = "UPDATE contratos_hojas_vida SET " . implode(', ', $setPart) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Obtiene un registro por su ID
     */
    public function obtenerPorId(int $id): ?array {
        $sql = "SELECT c.*, u.nombre AS usuario_portal_nombre, u.cargo AS usuario_portal_cargo
                FROM contratos_hojas_vida c
                LEFT JOIN usuarios u ON c.usuario_id = u.usuario_id
                WHERE c.id = :id
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    /**
     * Obtiene un registro por usuario_id
     */
    public function obtenerPorUsuarioId(int $usuario_id): ?array {
        $sql = "SELECT * FROM contratos_hojas_vida WHERE usuario_id = :uid ORDER BY id DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':uid', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    /**
     * Lista todos los contratos con filtros opcionales de búsqueda y estado
     */
    public function obtenerTodos(?string $busqueda = null, ?string $estado = null): array {
        $sql = "SELECT c.*, u.nombre AS usuario_portal_nombre
                FROM contratos_hojas_vida c
                LEFT JOIN usuarios u ON c.usuario_id = u.usuario_id
                WHERE 1=1";
        $params = [];

        if (!empty($busqueda)) {
            $sql .= " AND (c.nombre_completo LIKE :busq OR c.cedula LIKE :busq OR c.cargo LIKE :busq OR c.email LIKE :busq)";
            $params[':busq'] = '%' . trim($busqueda) . '%';
        }

        if (!empty($estado)) {
            $sql .= " AND c.estado = :estado";
            $params[':estado'] = trim($estado);
        }

        $sql .= " ORDER BY c.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Elimina un contrato por su ID
     */
    public function eliminar(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM contratos_hojas_vida WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Obtiene la lista de usuarios del sistema activos para auto-llenado
     */
    public function obtenerUsuariosParaSelect(): array {
        $sql = "SELECT usuario_id, nombre, cedula, cargo, area, email, celular, telefono_emergencia
                FROM usuarios
                WHERE estado = 'activo'
                ORDER BY nombre ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un usuario específico para la API de auto-llenado
     */
    public function obtenerUsuarioParaAutoLlenado(int $usuario_id): ?array {
        $sql = "SELECT usuario_id, nombre, cedula, cargo, area, email, celular, telefono_emergencia
                FROM usuarios
                WHERE usuario_id = :id
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    /**
     * Estadísticas rápidas para el hero banner
     */
    public function obtenerEstadisticas(): array {
        $sql = "SELECT 
                    COUNT(*) AS total,
                    SUM(CASE WHEN estado = 'activo' THEN 1 ELSE 0 END) AS activos,
                    SUM(CASE WHEN LOWER(cargo) LIKE '%conductor%' THEN 1 ELSE 0 END) AS conductores,
                    SUM(CASE WHEN LOWER(tipo_contrato) LIKE '%indefinido%' THEN 1 ELSE 0 END) AS indefinidos
                FROM contratos_hojas_vida";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [
            'total' => 0, 'activos' => 0, 'conductores' => 0, 'indefinidos' => 0
        ];
    }
}
