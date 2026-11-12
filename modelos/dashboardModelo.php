<?php
// modelos/dashboardModelo.php

class DashboardModelo {
    private $db;

    // Categorías expresamente excluidas para el rol SuperUsuario
    private $categoriasExcluidasSuperUsuario = [
        'Técnico',
        'Remisiones',
        'Pruebas',
        'Planificación',
        'Laboratorio',
        'Inventario',
        'Calidad'
    ];

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    /**
     * Verifica si una categoría pertenece al grupo excluido de SuperUsuario
     */
    private function esCategoriaExcluidaSuperUsuario($categoria) {
        $cLow = strtolower(trim($categoria));
        return (
            strpos($cLow, 'cnic') !== false ||
            strpos($cLow, 'tecn') !== false ||
            strpos($cLow, 'remis') !== false ||
            strpos($cLow, 'prueb') !== false ||
            strpos($cLow, 'planif') !== false ||
            strpos($cLow, 'laborat') !== false ||
            strpos($cLow, 'invent') !== false ||
            strpos($cLow, 'calidad') !== false
        );
    }

    /**
     * Obtiene la información completa del usuario por su ID
     */
    public function obtenerUsuarioPorId($usuario_id) {
        $sql = "SELECT u.usuario_id, u.nombre, u.cedula, u.cargo, u.area, 
                       u.email, u.celular, u.usuario, u.nivel_acceso, 
                       u.ultimo_acceso, u.estado, u.foto_perfil,
                       t.nombreTipoUsuario AS rol_nombre
                FROM usuarios u
                LEFT JOIN tipousuario t ON u.nivel_acceso = t.idTipoUsuario
                WHERE u.usuario_id = :usuario_id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene las rutas activas permitidas para el rol del usuario agrupadas por categoría.
     * Para SuperUsuario se excluyen: Técnico, Remisiones, Pruebas, Planificación, Laboratorio, Inventario y Calidad.
     */
    public function obtenerModulosPorRol($rol_id) {
        // Rutas técnicas de backend o internas que no deben mostrarse como botones de menú
        $rutasExcluidas = [
            'login', 'enviarCodigo', 'mensajeEnviado', 'solicitarCodigo', 
            'resetPassword', 'procesarResetPassword', 'error404', 
            'procesarCambioPassword', 'planificacionEliminar', 
            'armadoEliminar', 'fallasEliminar', 'repuestoNuevoEliminar', 
            'repuestoRecuperadoEliminar', 'tipoMaquinaEliminar', 
            'tipoSoftwareEliminar', 'usuarioEliminar', 'rutaEliminar',
            'mantenimientoEliminar', 'remisionEliminar', 'itemPruebaEliminar', 
            'itemQCEliminar'
        ];

        $esSuperUsuario = ((int)$rol_id === 1);

        if ($esSuperUsuario) {
            // SuperUsuario: consulta rutas activas y descarta categorías excluidas
            $sql = "SELECT id_ruta, nombre_ruta, nombre_mostrar, descripcion, categoria, controlador_ruta
                    FROM rutas
                    WHERE estado = 'activo'
                    ORDER BY categoria ASC, nombre_ruta ASC";
            $stmt = $this->db->query($sql);
            $rutasRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $rutas = [];
            foreach ($rutasRaw as $r) {
                if ($this->esCategoriaExcluidaSuperUsuario($r['categoria'])) {
                    continue;
                }
                $rutas[] = $r;
            }
        } else {
            // Gestión Humana y Empleado consultan permisos asignados en rol_permisos
            $sql = "SELECT r.id_ruta, r.nombre_ruta, r.nombre_mostrar, r.descripcion, r.categoria, r.controlador_ruta
                    FROM rol_permisos rp
                    JOIN rutas r ON rp.ruta_id = r.id_ruta
                    WHERE rp.rol_id = :rol_id 
                      AND r.estado = 'activo'
                    ORDER BY r.categoria ASC, r.nombre_ruta ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
            $stmt->execute();
            $rutas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Agrupar rutas por categoría
        $agrupados = [];
        foreach ($rutas as $ruta) {
            if (in_array($ruta['nombre_ruta'], $rutasExcluidas, true)) {
                continue;
            }
            $cat = !empty($ruta['categoria']) ? trim($ruta['categoria']) : 'General';
            if (!isset($agrupados[$cat])) {
                $agrupados[$cat] = [];
            }
            $agrupados[$cat][] = $ruta;
        }

        return $agrupados;
    }

    /**
     * Obtiene el listado plano de nombres de rutas permitidas
     */
    public function obtenerListaRutasPermitidas($rol_id) {
        if ((int)$rol_id === 1) {
            $sql = "SELECT nombre_ruta, categoria FROM rutas WHERE estado = 'activo'";
            $stmt = $this->db->query($sql);
            $todas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $permitidas = [];
            foreach ($todas as $r) {
                if ($this->esCategoriaExcluidaSuperUsuario($r['categoria'])) {
                    continue;
                }
                $permitidas[] = $r['nombre_ruta'];
            }
            return $permitidas;
        }

        $sql = "SELECT r.nombre_ruta 
                FROM rol_permisos rp
                JOIN rutas r ON rp.ruta_id = r.id_ruta
                WHERE rp.rol_id = :rol_id AND r.estado = 'activo'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Obtiene los últimos accesos registrados del usuario en la tabla login
     */
    public function obtenerUltimosAccesos($usuario_id, $limite = 5) {
        $sql = "SELECT login_id, fecha, hora, ip, usuario
                FROM login
                WHERE usuario_id = :usuario_id
                ORDER BY login_id DESC
                LIMIT :limite";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene estadísticas e indicadores según los 3 roles
     */
    public function obtenerEstadisticas($rol_id, $usuario_id) {
        $stats = [
            'total_usuarios'      => 0,
            'total_colaboradores' => 0,
            'total_rutas'         => 0,
            'mis_accesos_total'   => 0,
            'modulos_rol'         => 0
        ];

        try {
            // Inicios de sesión del usuario actual
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM login WHERE usuario_id = :usuario_id");
            $stmt->execute([':usuario_id' => $usuario_id]);
            $stats['mis_accesos_total'] = (int)$stmt->fetchColumn();

            $rol = (int)$rol_id;

            if ($rol === 1) {
                // SuperUsuario: Total de usuarios y rutas autorizadas para su rol
                $stats['total_usuarios'] = (int)$this->db->query("SELECT COUNT(*) FROM usuarios WHERE estado = 'activo'")->fetchColumn();
                $rutasPermitidas = $this->obtenerListaRutasPermitidas(1);
                $stats['total_rutas'] = count($rutasPermitidas);
                $stats['modulos_rol'] = $stats['total_rutas'];
            } elseif ($rol === 2) {
                // Gestión Humana: Conteo de colaboradores y módulos de talento humano
                $stats['total_colaboradores'] = (int)$this->db->query("SELECT COUNT(*) FROM usuarios WHERE estado = 'activo'")->fetchColumn();
                $stmtPerm = $this->db->prepare("SELECT COUNT(*) FROM rol_permisos rp JOIN rutas r ON rp.ruta_id = r.id_ruta WHERE rp.rol_id = :rol_id AND r.estado = 'activo'");
                $stmtPerm->execute([':rol_id' => $rol]);
                $stats['modulos_rol'] = (int)$stmtPerm->fetchColumn();
            } else {
                // Empleado: Conteo de módulos asignados
                $stmtPerm = $this->db->prepare("SELECT COUNT(*) FROM rol_permisos rp JOIN rutas r ON rp.ruta_id = r.id_ruta WHERE rp.rol_id = :rol_id AND r.estado = 'activo'");
                $stmtPerm->execute([':rol_id' => $rol]);
                $stats['modulos_rol'] = (int)$stmtPerm->fetchColumn();
            }
        } catch (Exception $e) {
            // Silencioso
        }

        return $stats;
    }
}
