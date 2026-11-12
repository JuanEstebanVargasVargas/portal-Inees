<?php
// modelos/flujoModelo.php

class FlujoModelo {
    private $db;

    public const AREAS = [
        'RECURSOS HUMANOS' => 'Recursos Humanos',
        'GERENCIA'         => 'Gerencia',
        'TECNICOS'         => 'Técnicos',
        'ADMINISTRATIVO'   => 'Administrativo',
        'EMPLEADO'         => 'Empleado'
    ];

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    /**
     * Obtiene los flujos activos filtrados por área, búsqueda y lista de áreas permitidas
     */
    public function obtenerFlujos($area = '', $busqueda = '', $areasPermitidas = []) {
        $sql = "SELECT f.*, u.nombre AS autor_nombre, u.cargo AS autor_cargo, u.usuario AS autor_usuario
                FROM flujos_archivos f
                LEFT JOIN usuarios u ON f.usuario_id = u.usuario_id
                WHERE f.estado = 'activo'";
        
        $params = [];

        // Si se seleccionó un área específica
        if (!empty($area) && $area !== 'TODOS') {
            $sql .= " AND f.area = :area";
            $params[':area'] = $area;
        } elseif (!empty($areasPermitidas)) {
            // Si no seleccionó un área específica pero tiene un grupo de áreas autorizadas
            $inPlaceholders = [];
            foreach ($areasPermitidas as $idx => $aPerm) {
                $pName = ':perm_' . $idx;
                $inPlaceholders[] = $pName;
                $params[$pName] = $aPerm;
            }
            $sql .= " AND f.area IN (" . implode(',', $inPlaceholders) . ")";
        }

        if (!empty($busqueda)) {
            $sql .= " AND (f.titulo LIKE :busqueda OR f.descripcion LIKE :busqueda OR f.nombre_original LIKE :busqueda)";
            $params[':busqueda'] = '%' . $busqueda . '%';
        }

        $sql .= " ORDER BY f.fecha_subida DESC, f.id DESC";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene el conteo de flujos activos por cada una de las 5 áreas
     */
    public function obtenerConteoPorArea() {
        $conteo = [
            'RECURSOS HUMANOS' => 0,
            'GERENCIA'         => 0,
            'TECNICOS'         => 0,
            'ADMINISTRATIVO'   => 0,
            'EMPLEADO'         => 0,
            'TOTAL'            => 0
        ];

        $sql = "SELECT area, COUNT(*) AS total
                FROM flujos_archivos
                WHERE estado = 'activo'
                GROUP BY area";
        $stmt = $this->db->query($sql);
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $totalGeneral = 0;
        foreach ($filas as $f) {
            $a = $f['area'];
            if (isset($conteo[$a])) {
                $conteo[$a] = (int)$f['total'];
                $totalGeneral += (int)$f['total'];
            }
        }
        $conteo['TOTAL'] = $totalGeneral;

        return $conteo;
    }

    /**
     * Obtiene un flujo por su ID
     */
    public function obtenerFlujoPorId($id) {
        $sql = "SELECT f.*, u.nombre AS autor_nombre, u.cargo AS autor_cargo
                FROM flujos_archivos f
                LEFT JOIN usuarios u ON f.usuario_id = u.usuario_id
                WHERE f.id = :id AND f.estado = 'activo'
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Guarda un nuevo flujo en la base de datos
     */
    public function guardarFlujo($datos) {
        $sql = "INSERT INTO flujos_archivos 
                (titulo, descripcion, area, nombre_original, ruta_archivo, tamano, tipo, usuario_id, fecha_subida, estado)
                VALUES 
                (:titulo, :descripcion, :area, :nombre_original, :ruta_archivo, :tamano, :tipo, :usuario_id, :fecha_subida, 'activo')";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':titulo'          => $datos['titulo'],
            ':descripcion'     => $datos['descripcion'] ?? null,
            ':area'            => $datos['area'],
            ':nombre_original' => $datos['nombre_original'],
            ':ruta_archivo'    => $datos['ruta_archivo'],
            ':tamano'          => (int)($datos['tamano'] ?? 0),
            ':tipo'            => $datos['tipo'] ?? '',
            ':usuario_id'      => (int)$datos['usuario_id'],
            ':fecha_subida'    => $datos['fecha_subida'] ?? date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Elimina lógicamente un flujo (cambia estado a inactivo)
     */
    public function eliminarFlujo($id) {
        $sql = "UPDATE flujos_archivos SET estado = 'inactivo' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
