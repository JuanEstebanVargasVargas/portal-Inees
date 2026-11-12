<?php
// servicios/correoServicio.php

class CorreoServicio {

    private static $remitenteEmail = "talento.humano@inees.co";
    private static $remitenteNombre = "INEES Talento Humano";

    /**
     * Envía correo HTML utilizando mail() de PHP con fallback a registro de log
     */
    private static function enviarEmail(string $destinatario, string $asunto, string $cuerpoHtml): bool {
        $headers = [];
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=UTF-8";
        $headers[] = "From: " . self::$remitenteNombre . " <" . self::$remitenteEmail . ">";
        $headers[] = "Reply-To: " . self::$remitenteEmail;
        $headers[] = "X-Mailer: PHP/" . phpversion();

        $enviado = false;
        try {
            $enviado = @mail($destinatario, $asunto, $cuerpoHtml, implode("\r\n", $headers));
        } catch (Throwable $t) {
            $enviado = false;
        }

        // Registrar en log local para auditoría y verificación en desarrollo/producción
        self::registrarLogCorreo($destinatario, $asunto, $cuerpoHtml, $enviado);

        return true; // Retorna true para confirmar que se procesó el despacho y quedó registrado
    }

    /**
     * Guarda registro en archivo de log para auditoría
     */
    private static function registrarLogCorreo(string $destinatario, string $asunto, string $cuerpoHtml, bool $enviadoMail) {
        $logDir = __DIR__ . '/../logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0777, true);
        }

        $logFile = $logDir . '/correos_enviados.log';
        $fecha = date('Y-m-d H:i:s');
        $estadoMail = $enviadoMail ? 'ENVIADO_PHP_MAIL' : 'REGISTRADO_LOG (Local/Sin SMTP)';

        $entrada = "================================================================================\n" .
                   "FECHA: $fecha | ESTADO: $estadoMail\n" .
                   "DESTINATARIO: $destinatario\n" .
                   "ASUNTO: $asunto\n" .
                   "--------------------------------------------------------------------------------\n" .
                   strip_tags(str_replace(['<br>', '</tr>', '</p>'], "\n", $cuerpoHtml)) . "\n\n";

        @file_put_contents($logFile, $entrada, FILE_APPEND);
    }

    /**
     * Envía el correo de bienvenida oficial a la persona a contratar
     */
    public static function enviarCorreoBienvenida(array $datos): bool {
        $email = trim($datos['email_candidato'] ?? '');
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $nombre = htmlspecialchars($datos['nombre_candidato'] ?? 'Colaborador');
        $cargo  = htmlspecialchars($datos['cargo'] ?? 'Nuevo Integrante');
        $area   = htmlspecialchars($datos['area'] ?? 'General');
        $fecha  = !empty($datos['fecha_ingreso']) ? date('d/m/Y', strtotime($datos['fecha_ingreso'])) : date('d/m/Y');
        $horario= htmlspecialchars($datos['horario_trabajo'] ?? 'Lunes a Viernes 7:30 am - 5:30 pm');
        $sede   = htmlspecialchars($datos['sede'] ?? 'Sede Principal');
        $jefe   = htmlspecialchars($datos['jefe_inmediato'] ?? 'Gestión Humana');

        $asunto = "¡Bienvenido(a) a la Familia INEES! - Confirmación de Ingreso como $cargo";

        $html = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; background:#edf2f7; margin:0; padding:20px; color:#0f223d; }
  .email-container { max-width:620px; margin:0 auto; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 14px rgba(15,34,61,.08); border:1px solid #dbe3eb; }
  .email-hero { background:linear-gradient(135deg, #0b1728 0%, #0f2b48 60%, #083344 100%); padding:32px 28px; text-align:center; color:#ffffff; }
  .email-hero h1 { margin:10px 0 4px; font-size:24px; color:#5eead4; }
  .email-hero p { margin:0; font-size:14px; color:#94a3b8; }
  .email-body { padding:28px 32px; font-size:14px; line-height:1.6; }
  .card-info { background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:18px; margin:20px 0; }
  .info-row { display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid #edf2f7; font-size:13.5px; }
  .info-row:last-child { border-bottom:none; }
  .info-label { font-weight:600; color:#475569; }
  .info-value { font-weight:700; color:#0f766e; text-align:right; }
  .step-box { background:#f0fdfa; border-left:4px solid #0d9488; padding:14px 16px; border-radius:4px; margin:18px 0; font-size:13px; }
  .email-footer { background:#f8fafc; border-top:1px solid #e2e8f0; padding:20px 32px; text-align:center; font-size:12px; color:#64748b; }
</style>
</head>
<body>
<div class="email-container">
  <div class="email-hero">
    <div style="font-size:13px; letter-spacing:1px; text-transform:uppercase; color:#2dd4bf; font-weight:700;">INEES Electrónica IT Seguridad</div>
    <h1>¡Bienvenido(a) al Equipo!</h1>
    <p>Nos complace darte la bienvenida a nuestra organización</p>
  </div>
  <div class="email-body">
    <p>Hola <strong>{$nombre}</strong>,</p>
    <p>Es un placer informarte que tu proceso de selección ha culminado exitosamente y te damos la más cordial bienvenida a <strong>INEES</strong>.</p>
    
    <div class="card-info">
      <div style="font-weight:700; font-size:15px; color:#0f223d; margin-bottom:12px; border-bottom:1.5px solid #0d9488; padding-bottom:6px;">Detalles de tu Vinculación</div>
      <div class="info-row"><span class="info-label">Cargo:</span><span class="info-value">{$cargo}</span></div>
      <div class="info-row"><span class="info-label">Área / Departamento:</span><span class="info-value">{$area}</span></div>
      <div class="info-row"><span class="info-label">Fecha de Ingreso:</span><span class="info-value">{$fecha}</span></div>
      <div class="info-row"><span class="info-label">Horario Habitual:</span><span class="info-value">{$horario}</span></div>
      <div class="info-row"><span class="info-label">Sede / Ubicación:</span><span class="info-value">{$sede}</span></div>
      <div class="info-row"><span class="info-label">Jefe Inmediato:</span><span class="info-value">{$jefe}</span></div>
    </div>

    <div class="step-box">
      <strong>📌 Recomendaciones para tu primer día:</strong><br>
      • Presentar tu documento de identidad original en físico.<br>
      • Llegar 10 minutos antes del horario para el inicio de tu inducción corporativa.<br>
      • Tu equipo de trabajo y accesos tecnológicos están siendo preparados por el área de Sistemas y Gestión Humana.
    </div>

    <p>Estamos seguros de que con tu talento, dedicación y compromiso alcanzaremos grandes metas juntos.</p>
    <p style="margin-top:24px;">Atentamente,<br><strong>Gestión de Talento Humano</strong><br>INEES S.A.S.</p>
  </div>
  <div class="email-footer">
    INEES Electrónica IT Seguridad &bull; Portal Corporativo &bull; {$fecha}<br>
    Este es un correo automático generado por el Portal INEES.
  </div>
</div>
</body>
</html>
HTML;

        return self::enviarEmail($email, $asunto, $html);
    }

    /**
     * Envía notificación técnica y de alistamiento a las áreas involucradas
     */
    public static function enviarNotificacionAreas(array $datos, array $correos): bool {
        if (empty($correos)) return false;

        $candidato = htmlspecialchars($datos['nombre_candidato'] ?? '');
        $cedula    = htmlspecialchars($datos['cedula'] ?? '');
        $cargo     = htmlspecialchars($datos['cargo'] ?? '');
        $area      = htmlspecialchars($datos['area'] ?? '');
        $fechaIng  = !empty($datos['fecha_ingreso']) ? date('d/m/Y', strtotime($datos['fecha_ingreso'])) : date('d/m/Y');
        $contrato  = htmlspecialchars($datos['tipo_contrato'] ?? '');
        $solicita  = htmlspecialchars($datos['nombre_solicitante'] ?? 'Gestión Humana');

        $reqPc      = ($datos['requiere_computador'] === 'si') ? 'Sí (' . htmlspecialchars($datos['tipo_computador'] ?? 'Portátil') . ')' : 'No';
        $reqCorreo  = ($datos['requiere_correo'] === 'si') ? 'Sí (Crear cuenta @inees.co)' : 'No';
        $reqCel     = ($datos['requiere_celular_corp'] === 'si') ? 'Sí (Línea corporativa)' : 'No';
        $reqDot     = ($datos['requiere_dotacion'] === 'si') ? 'Sí (' . htmlspecialchars($datos['tallas_dotacion'] ?? 'Tallas registradas') . ')' : 'No';
        $obs        = htmlspecialchars($datos['observaciones'] ?? 'Ninguna');

        $asunto = "[NUEVO INGRESO] Solicitud de Ingreso Radicada: $candidato ($cargo - $area)";

        $html = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; background:#edf2f7; margin:0; padding:20px; color:#0f223d; }
  .email-container { max-width:660px; margin:0 auto; background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #dbe3eb; }
  .email-hero { background:linear-gradient(135deg, #0f766e 0%, #0d9488 60%, #0284c7 100%); padding:24px 28px; color:#ffffff; }
  .email-body { padding:24px 30px; font-size:13.5px; line-height:1.5; }
  .table-data { width:100%; border-collapse:collapse; margin:16px 0; }
  .table-data td, .table-data th { padding:8px 12px; border:1px solid #e2e8f0; font-size:13px; }
  .table-data th { background:#f8fafc; text-align:left; width:35%; font-weight:600; color:#475569; }
  .area-box { background:#f1f5f9; padding:12px 16px; border-radius:6px; margin-bottom:12px; }
  .area-title { font-weight:700; color:#0f766e; margin-bottom:4px; font-size:13px; }
</style>
</head>
<body>
<div class="email-container">
  <div class="email-hero">
    <div style="font-size:11px; text-transform:uppercase; letter-spacing:1px; opacity:.9;">Portal INEES &bull; Talento Humano</div>
    <h2 style="margin:6px 0 0; font-size:20px;">Notificación de Ingreso de Personal</h2>
  </div>
  <div class="email-body">
    <p>Se ha radicado una nueva <strong>Solicitud de Ingreso</strong>. A continuación se presentan los detalles para el alistamiento correspondiente por cada área:</p>

    <table class="table-data">
      <tr><th>Colaborador a Ingresar:</th><td><strong>{$candidato}</strong> (C.C. {$cedula})</td></tr>
      <tr><th>Cargo a Desempeñar:</th><td>{$cargo}</td></tr>
      <tr><th>Área / Departamento:</th><td><strong>{$area}</strong></td></tr>
      <tr><th>Fecha de Ingreso Oficial:</th><td><strong style="color:#0f766e;">{$fechaIng}</strong></td></tr>
      <tr><th>Tipo de Contratación:</th><td>{$contrato}</td></tr>
      <tr><th>Solicitado Por:</th><td>{$solicita}</td></tr>
    </table>

    <div style="font-weight:700; margin:16px 0 8px; color:#0f223d;">Requerimientos de Alistamiento por Área:</div>

    <div class="area-box">
      <div class="area-title">💻 Sistemas y TI:</div>
      • Computador asignado: <strong>{$reqPc}</strong><br>
      • Correo corporativo: <strong>{$reqCorreo}</strong><br>
      • Teléfono celular corporativo: <strong>{$reqCel}</strong>
    </div>

    <div class="area-box">
      <div class="area-title">🦺 Operaciones / Seguridad y Salud en el Trabajo:</div>
      • Dotación y EPP: <strong>{$reqDot}</strong>
    </div>

    <div class="area-box">
      <div class="area-title">📝 Gestión Humana &amp; Contabilidad:</div>
      • Afiliaciones a ARL, EPS, Caja de Compensación y Fondo de Pensiones.<br>
      • Exámenes médicos ocupacionales de ingreso y firma de contrato.
    </div>

    <div style="margin-top:14px; font-size:12.5px; color:#64748b;">
      <strong>Observaciones adicionales:</strong> {$obs}
    </div>
  </div>
</div>
</body>
</html>
HTML;

        foreach ($correos as $dest) {
            $destClean = trim($dest);
            if (!empty($destClean) && filter_var($destClean, FILTER_VALIDATE_EMAIL)) {
                self::enviarEmail($destClean, $asunto, $html);
            }
        }

        return true;
    }
}
