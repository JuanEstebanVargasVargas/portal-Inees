<?php
/**
 * PublicacionModelo — CRUD de publicaciones institucionales
 * Tabla: publicaciones (id, titulo, contenido, media_archivo, media_tipo,
 *                       autor_id, autor_nombre, autor_nivel, fecha_publicacion, estado)
 * autor_nivel: 2 = Gestión Humana, 5 = Sistema de Gestión
 */
class PublicacionModelo {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Retorna publicaciones activas, más recientes primero.
     */
    public function obtenerPublicaciones(int $limite = 20): array {
        $stmt = $this->pdo->prepare(
            "SELECT id, titulo, contenido, media_archivo, media_tipo,
                    autor_id, autor_nombre, autor_nivel, fecha_publicacion
             FROM publicaciones
             WHERE estado = 'activo'
             ORDER BY fecha_publicacion DESC
             LIMIT :limite"
        );
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crea una nueva publicación (Gestión Humana o Sistema de Gestión, validado en controlador).
     *
     * @param string      $titulo
     * @param string      $contenido
     * @param int         $autorId
     * @param string      $autorNombre
     * @param int         $autorNivel    2=Gestión Humana, 5=Sistema de Gestión
     * @param string|null $mediaArchivo  Nombre de archivo guardado en img/publicaciones/
     * @param string      $mediaTipo     'ninguno' | 'imagen' | 'video'
     */
    public function crearPublicacion(
        string  $titulo,
        string  $contenido,
        int     $autorId,
        string  $autorNombre,
        int     $autorNivel   = 2,
        ?string $mediaArchivo = null,
        string  $mediaTipo    = 'ninguno'
    ): bool {
        $stmt = $this->pdo->prepare(
            "INSERT INTO publicaciones (titulo, contenido, media_archivo, media_tipo, autor_id, autor_nombre, autor_nivel)
             VALUES (:titulo, :contenido, :media_archivo, :media_tipo, :autor_id, :autor_nombre, :autor_nivel)"
        );
        return $stmt->execute([
            ':titulo'        => trim($titulo),
            ':contenido'     => trim($contenido),
            ':media_archivo' => $mediaArchivo,
            ':media_tipo'    => $mediaTipo,
            ':autor_id'      => $autorId,
            ':autor_nombre'  => trim($autorNombre),
            ':autor_nivel'   => $autorNivel,
        ]);
    }

    /**
     * Desactiva (soft-delete) una publicación.
     */
    public function eliminarPublicacion(int $id): bool {
        $stmt = $this->pdo->prepare(
            "UPDATE publicaciones SET estado = 'inactivo' WHERE id = :id"
        );
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Total de publicaciones activas.
     */
    public function totalPublicaciones(): int {
        return (int) $this->pdo->query(
            "SELECT COUNT(*) FROM publicaciones WHERE estado = 'activo'"
        )->fetchColumn();
    }
}
