<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nuevo mensaje de contacto</title>
</head>
<body style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background-color: #f5f5f5; padding: 20px;">
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
          <tr>
            <td style="background: #b91c1c; padding: 16px 24px; color: #fff;">
              <h1 style="margin: 0; font-size: 18px;">
                Nuevo mensaje desde el formulario de contacto
              </h1>
              <p style="margin: 4px 0 0; font-size: 12px; opacity: 0.9;">
                Academia Ariete
              </p>
            </td>
          </tr>

          <tr>
            <td style="padding: 20px 24px; font-size: 14px; color: #111827;">
              <p style="margin-top: 0;">
                Has recibido un nuevo mensaje desde la web de <strong>Academia Ariete</strong>:
              </p>

              <table cellpadding="0" cellspacing="0" style="width: 100%; font-size: 14px; margin-top: 10px;">
                <tr>
                  <td style="padding: 4px 0; width: 120px; color: #6b7280;">Nombre:</td>
                  <td style="padding: 4px 0;">
                    <strong>{{ ($datos['nombre'] ?? '') . ' ' . ($datos['apellidos'] ?? '') }}</strong>
                  </td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Email:</td>
                  <td style="padding: 4px 0;">{{ $datos['email'] ?? '' }}</td>
                </tr>

                @if(!empty($datos['telefono']))
                  <tr>
                    <td style="padding: 4px 0; color: #6b7280;">Teléfono:</td>
                    <td style="padding: 4px 0;">{{ $datos['telefono'] }}</td>
                  </tr>
                @endif

                @if(!empty($datos['asunto']))
                  <tr>
                    <td style="padding: 4px 0; color: #6b7280;">Asunto:</td>
                    <td style="padding: 4px 0;">{{ $datos['asunto'] }}</td>
                  </tr>
                @endif
              </table>

              <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 16px 0;">

              <p style="margin: 0 0 6px; font-weight: 600;">Mensaje:</p>
              <p style="margin: 0; white-space: pre-line; line-height: 1.5;">
                {!! nl2br(e($datos['mensaje'] ?? '')) !!}
              </p>

              @if(!empty($datos['adjunto_path']))
                <p style="margin-top: 12px; font-size: 12px; color: #6b7280;">
                  El remitente ha adjuntado un archivo junto al mensaje.
                </p>
              @endif
            </td>
          </tr>

          <tr>
            <td style="padding: 12px 24px; font-size: 11px; color: #9ca3af; background: #f9fafb; text-align: center;">
              Este correo se ha generado automáticamente desde el formulario de contacto de la web.<br>
              Por favor, responde directamente a <strong>{{ $datos['email'] ?? '' }}</strong> si quieres contactar con la persona.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
