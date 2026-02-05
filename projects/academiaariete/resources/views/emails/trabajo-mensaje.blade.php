<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nueva candidatura - Trabaja con nosotros</title>
</head>
<body style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background-color: #f5f5f5; padding: 20px;">
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
          {{-- Cabecera roja --}}
          <tr>
            <td style="background: #b91c1c; padding: 16px 24px; color: #fff;">
              <h1 style="margin: 0; font-size: 18px;">
                Nueva candidatura desde "Trabaja con nosotros"
              </h1>
              <p style="margin: 4px 0 0; font-size: 12px; opacity: 0.9;">
                Academia Ariete
              </p>
            </td>
          </tr>

          {{-- Cuerpo principal --}}
          <tr>
            <td style="padding: 20px 24px; font-size: 14px; color: #111827;">
              <p style="margin-top: 0;">
                Has recibido una nueva candidatura desde el formulario de <strong>Trabaja con nosotros</strong>:
              </p>

              @php
                $areas = $datos['areas'] ?? [];
              @endphp

              <table cellpadding="0" cellspacing="0" style="width: 100%; font-size: 14px; margin-top: 10px;">
                <tr>
                  <td style="padding: 4px 0; width: 140px; color: #6b7280;">Perfil:</td>
                  <td style="padding: 4px 0;">
                    <strong>
                      @if(($datos['perfil'] ?? '') === 'docente')
                        Docente
                      @elseif(($datos['perfil'] ?? '') === 'no_docente')
                        No docente
                      @else
                        {{ $datos['perfil'] ?? '' }}
                      @endif
                    </strong>
                  </td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Nombre:</td>
                  <td style="padding: 4px 0;">
                    <strong>{{ ($datos['nombre'] ?? '') . ' ' . ($datos['apellidos'] ?? '') }}</strong>
                  </td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Email:</td>
                  <td style="padding: 4px 0;">{{ $datos['email'] ?? '' }}</td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Teléfono:</td>
                  <td style="padding: 4px 0;">{{ $datos['telefono'] ?? '' }}</td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Población:</td>
                  <td style="padding: 4px 0;">{{ $datos['poblacion'] ?? '' }}</td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Provincia:</td>
                  <td style="padding: 4px 0;">{{ $datos['provincia'] ?? '' }}</td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Dirección:</td>
                  <td style="padding: 4px 0;">{{ $datos['direccion'] ?? '' }}</td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Código postal:</td>
                  <td style="padding: 4px 0;">{{ $datos['cp'] ?? '' }}</td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Áreas profesionales:</td>
                  <td style="padding: 4px 0;">
                    {{ $areas ? implode(', ', $areas) : 'No especificado' }}
                  </td>
                </tr>
              </table>

              <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 16px 0;">

              <p style="margin: 0 0 6px; font-weight: 600;">Mensaje de presentación:</p>
              <p style="margin: 0; white-space: pre-line; line-height: 1.5;">
                {!! nl2br(e($datos['mensaje'] ?? '')) !!}
              </p>

              @if(!empty($datos['cv_path']))
                <p style="margin-top: 14px; font-size: 13px; color: #6b7280;">
                  <strong>Currículum:</strong> Se ha adjuntado el archivo al correo.
                </p>
              @else
                <p style="margin-top: 14px; font-size: 13px; color: #6b7280;">
                  <strong>Currículum:</strong> No se ha adjuntado ningún archivo.
                </p>
              @endif
            </td>
          </tr>

          {{-- Pie --}}
          <tr>
            <td style="padding: 12px 24px; font-size: 11px; color: #9ca3af; background: #f9fafb; text-align: center;">
              Este correo se ha generado automáticamente desde el formulario
              <strong>"Trabaja con nosotros"</strong> de la web.<br>
              Para responder a la persona candidata, escribe a <strong>{{ $datos['email'] ?? '' }}</strong>.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
