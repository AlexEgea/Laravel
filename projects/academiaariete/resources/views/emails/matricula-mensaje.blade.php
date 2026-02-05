<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Nueva matrícula online</title>
</head>
<body style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background-color: #f5f5f5; padding: 20px;">
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
          {{-- Cabecera --}}
          <tr>
            <td style="background: #b91c1c; padding: 16px 24px; color: #fff;">
              <h1 style="margin: 0; font-size: 18px;">
                Nueva matrícula online
              </h1>
              <p style="margin: 4px 0 0; font-size: 12px; opacity: 0.9;">
                Academia Ariete
              </p>
            </td>
          </tr>

          {{-- Cuerpo --}}
          <tr>
            <td style="padding: 20px 24px; font-size: 14px; color: #111827;">
              <p style="margin-top: 0;">
                Has recibido una nueva <strong>matrícula online</strong> desde la web:
              </p>

              <table cellpadding="0" cellspacing="0" style="width: 100%; font-size: 14px; margin-top: 10px;">
                <tr>
                  <td style="padding: 4px 0; width: 160px; color: #6b7280;">Curso de matriculación:</td>
                  <td style="padding: 4px 0;">
                    <strong>{{ $datos['curso_matriculacion'] ?? '' }}</strong>
                  </td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Curso / módulo de oposiciones:</td>
                  <td style="padding: 4px 0;">
                    {{ $datos['curso_modulo'] ?? '' }}
                  </td>
                </tr>

                <tr><td colspan="2" style="padding-top: 10px;"></td></tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Nombre completo:</td>
                  <td style="padding: 4px 0;">
                    <strong>
                      {{ ($datos['nombre'] ?? '') }}
                      {{ ($datos['apellido1'] ?? '') }}
                      {{ ($datos['apellido2'] ?? '') }}
                    </strong>
                  </td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">DNI:</td>
                  <td style="padding: 4px 0;">{{ $datos['dni'] ?? '' }}</td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Fecha de nacimiento:</td>
                  <td style="padding: 4px 0;">{{ $datos['nacimiento'] ?? '' }}</td>
                </tr>

                <tr><td colspan="2" style="padding-top: 10px;"></td></tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Email:</td>
                  <td style="padding: 4px 0;">{{ $datos['email'] ?? '' }}</td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Teléfono:</td>
                  <td style="padding: 4px 0;">{{ $datos['telefono'] ?? '' }}</td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Dirección:</td>
                  <td style="padding: 4px 0;">
                    {{ $datos['direccion'] ?? '' }}<br>
                    {{ $datos['cp'] ?? '' }} - {{ $datos['poblacion'] ?? '' }} ({{ $datos['provincia'] ?? '' }})
                  </td>
                </tr>

                <tr><td colspan="2" style="padding-top: 10px;"></td></tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Titulación:</td>
                  <td style="padding: 4px 0;">{{ $datos['titulacion'] ?? '' }}</td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Forma de pago:</td>
                  <td style="padding: 4px 0;">
                    @if(($datos['forma_pago'] ?? '') === 'mensual')
                      Mensual
                    @elseif(($datos['forma_pago'] ?? '') === 'contado')
                      Al contado
                    @else
                      {{ $datos['forma_pago'] ?? '' }}
                    @endif
                  </td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">¿Cómo nos ha conocido?</td>
                  <td style="padding: 4px 0;">
                    {{ $datos['origen'] ?? '' }}
                    @if(!empty($datos['origen_otros']))
                      <br><em>Detalle: {{ $datos['origen_otros'] }}</em>
                    @endif
                  </td>
                </tr>

                <tr><td colspan="2" style="padding-top: 10px;"></td></tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Consiente info comercial:</td>
                  <td style="padding: 4px 0;">
                    {{ !empty($datos['consiente_info']) ? 'Sí' : 'No' }}
                  </td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Mantener datos como histórico:</td>
                  <td style="padding: 4px 0;">
                    {{ !empty($datos['consiente_historico']) ? 'Sí' : 'No' }}
                  </td>
                </tr>

                <tr>
                  <td style="padding: 4px 0; color: #6b7280;">Info de oferta educativa:</td>
                  <td style="padding: 4px 0;">
                    {{ !empty($datos['consiente_oferta']) ? 'Sí' : 'No' }}
                  </td>
                </tr>
              </table>

              <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 16px 0;">

              <p style="margin: 0 0 6px; font-weight: 600;">Observaciones:</p>
              <p style="margin: 0; white-space: pre-line; line-height: 1.5;">
                {!! nl2br(e($datos['observaciones'] ?? '')) !!}
              </p>

              <p style="margin-top: 16px; font-size: 13px; color: #6b7280;">
                <strong>Justificante de pago:</strong>
                @if(!empty($datos['justificante_path']))
                  adjuntado a este correo.
                @else
                  no adjuntado.
                @endif
                <br>
                <strong>Documentación adicional:</strong>
                @if(!empty($datos['adjuntos_path']))
                  adjuntada a este correo.
                @else
                  no adjuntada.
                @endif
              </p>
            </td>
          </tr>

          {{-- Pie --}}
          <tr>
            <td style="padding: 12px 24px; font-size: 11px; color: #9ca3af; background: #f9fafb; text-align: center;">
              Este correo se ha generado automáticamente desde el formulario de matrícula de la web.<br>
              Para contactar con el alumno, responde a <strong>{{ $datos['email'] ?? '' }}</strong>.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
