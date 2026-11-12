<?php
// modelos/organigramaModelo.php

class OrganigramaModelo
{
    private $db;

    public function __construct($conexion)
    {
        $this->db = $conexion;
    }

    /**
     * Obtiene el organigrama actual (el más reciente con es_actual = 1)
     */
    public function obtenerActual(): ?array
    {
        $stmt = $this->db->query(
            "SELECT * FROM organigrama
             WHERE es_actual = 1 AND estado = 'activo'
             ORDER BY id DESC LIMIT 1"
        );
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Obtiene el historial de versiones subidas (máx. 20)
     */
    public function obtenerHistorial(int $limite = 20): array
    {
        $stmt = $this->db->prepare(
            "SELECT o.*, u.nombre AS subido_por_nombre, u.cargo AS subido_por_cargo
             FROM organigrama o
             LEFT JOIN usuarios u ON o.usuario_id = u.usuario_id
             WHERE o.estado != 'inactivo'
             ORDER BY o.id DESC
             LIMIT :lim"
        );
        $stmt->bindValue(':lim', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Marca todos los registros como no actuales, luego inserta el nuevo
     */
    public function guardar(array $datos): bool
    {
        try {
            $this->db->beginTransaction();

            // Marcar registros anteriores como histórico
            $this->db->exec("UPDATE organigrama SET es_actual = 0, estado = 'historico' WHERE es_actual = 1");

            // Insertar el nuevo organigrama como actual
            $stmt = $this->db->prepare(
                "INSERT INTO organigrama
                 (titulo, version, descripcion, nombre_original, ruta_archivo, tipo_archivo, tamano, usuario_id, es_actual, fecha_subida, estado)
                 VALUES
                 (:titulo, :version, :descripcion, :nombre_original, :ruta_archivo, :tipo_archivo, :tamano, :usuario_id, 1, :fecha_subida, 'activo')"
            );
            $ok = $stmt->execute([
                ':titulo'          => $datos['titulo']          ?? 'Organigrama General Institucional',
                ':version'         => $datos['version']         ?? 'v1.0',
                ':descripcion'     => $datos['descripcion']     ?? null,
                ':nombre_original' => $datos['nombre_original'],
                ':ruta_archivo'    => $datos['ruta_archivo'],
                ':tipo_archivo'    => $datos['tipo_archivo'],
                ':tamano'          => (int)($datos['tamano']    ?? 0),
                ':usuario_id'      => (int)$datos['usuario_id'],
                ':fecha_subida'    => date('Y-m-d H:i:s'),
            ]);

            $this->db->commit();
            return $ok;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('OrganigramaModelo::guardar error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina lógicamente un registro del historial
     */
    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("UPDATE organigrama SET estado = 'inactivo' WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
