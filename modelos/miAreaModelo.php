<?php
// modelos/miAreaModelo.php

class MiAreaModelo {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    /**
     * Obtiene archivos activos filtrados por área(s) permitidas, categoría y búsqueda.
     * $areasPermitidas: array de áreas que el rol puede ver (vacío = todas, solo para SG)
     */
    public function obtenerArchivos($categoria = '', $busqueda = '', array $areasPermitidas = []) {
        $sql = "SELECT a.*, u.nombre AS autor_nombre, u.cargo AS autor_cargo, u.usuario AS autor_usuario
                FROM mi_area_archivos a
                LEFT JOIN usuarios u ON a.usuario_id = u.usuario_id
                WHERE a.estado = 'activo'";

        $params = [];

        // Restricción por áreas permitidas
        if (!empty($areasPermitidas)) {
            $placeholders = implode(',', array_fill(0, count($areasPermitidas), '?'));
            $sql .= " AND a.area IN ($placeholders)";
        }

        if (!empty($categoria) && $categoria !== 'todos') {
            $sql .= " AND a.categoria = :categoria";
            $params[':categoria'] = $categoria;
        }

        if (!empty($busqueda)) {
            $sql .= " AND (a.titulo LIKE :busqueda OR a.descripcion LIKE :busqueda OR a.nombre_original LIKE :busqueda)";
            $params[':busqueda'] = '%' . $busqueda . '%';
        }

        $sql .= " ORDER BY a.fecha_subida DESC, a.id DESC";

        $stmt = $this->db->prepare($sql);

        // Bind de las áreas con índice posicional (?)
        $i = 1;
        foreach ($areasPermitidas as $area) {
            $stmt->bindValue($i++, $area);
        }

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene categorías con conteo, filtradas por las áreas permitidas del rol
     */
    public function obtenerCategoriasConConteo(array $areasPermitidas = []) {
        if (!empty($areasPermitidas)) {
            $placeholders = implode(',', array_fill(0, count($areasPermitidas), '?'));
            $sql = "SELECT categoria, COUNT(*) AS total
                    FROM mi_area_archivos
                    WHERE estado = 'activo' AND area IN ($placeholders)
                    GROUP BY categoria ORDER BY categoria ASC";
            $stmt = $this->db->prepare($sql);
            $i = 1;
            foreach ($areasPermitidas as $area) $stmt->bindValue($i++, $area);
            $stmt->execute();
        } else {
            $stmt = $this->db->query("SELECT categoria, COUNT(*) AS total FROM mi_area_archivos WHERE estado='activo' GROUP BY categoria ORDER BY categoria ASC");
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Conteo de archivos por área (para badges de divisiones)
     */
    public function obtenerConteoPorArea() {
        $stmt = $this->db->query(
            "SELECT area, COUNT(*) AS total FROM mi_area_archivos WHERE estado='activo' GROUP BY area"
        );
        $result = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $r) {
            $result[$r['area']] = (int)$r['total'];
        }
        return $result;
    }

    /**
     * Obtiene un archivo por su ID
     */
    public function obtenerArchivoPorId($id) {
        $sql = "SELECT a.*, u.nombre AS autor_nombre, u.cargo AS autor_cargo
                FROM mi_area_archivos a
                LEFT JOIN usuarios u ON a.usuario_id = u.usuario_id
                WHERE a.id = :id AND a.estado = 'activo'
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Registra un nuevo archivo en la base de datos (incluye el área de destino)
     */
    public function guardarArchivo($datos) {
        $sql = "INSERT INTO mi_area_archivos 
                (titulo, descripcion, categoria, area, nombre_original, ruta_archivo, tamano, tipo, usuario_id, fecha_subida, estado)
                VALUES 
                (:titulo, :descripcion, :categoria, :area, :nombre_original, :ruta_archivo, :tamano, :tipo, :usuario_id, :fecha_subida, 'activo')";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':titulo'          => $datos['titulo'],
            ':descripcion'     => $datos['descripcion'] ?? null,
            ':categoria'       => !empty($datos['categoria']) ? trim($datos['categoria']) : 'General',
            ':area'            => $datos['area'] ?? 'GENERAL',
            ':nombre_original' => $datos['nombre_original'],
            ':ruta_archivo'    => $datos['ruta_archivo'],
            ':tamano'          => (int)($datos['tamano'] ?? 0),
            ':tipo'            => $datos['tipo'] ?? '',
            ':usuario_id'      => (int)$datos['usuario_id'],
            ':fecha_subida'    => $datos['fecha_subida'] ?? date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Elimina lógicamente un archivo (cambia estado a inactivo)
     */
    public function eliminarArchivo($id) {
        $sql = "UPDATE mi_area_archivos SET estado = 'inactivo' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Obtiene métricas generales de archivos
     */
    public function obtenerMetricas() {
        $sql = "SELECT 
                    COUNT(*) as total_archivos,
                    COUNT(DISTINCT categoria) as total_categorias,
                    COALESCE(SUM(tamano), 0) as total_tamano
                FROM mi_area_archivos
                WHERE estado = 'activo'";
        $stmt = $this->db->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
