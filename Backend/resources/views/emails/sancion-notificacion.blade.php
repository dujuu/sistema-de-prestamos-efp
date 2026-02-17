<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificación de Sanción</title>

    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 700px;
            background: #ffffff;
            margin: 40px auto;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border-top: 6px solid #2d5a99;
        }

        h1 {
            margin-top: 0;
            color: #2d5a99;
            font-size: 26px;
            font-weight: 700;
        }

        h2 {
            color: #2d5a99;
            margin-bottom: 5px;
            font-size: 18px;
        }

        p {
            font-size: 15px;
            line-height: 1.5;
            color: #444;
        }

        .info-box {
            background: #f0f4fa;
            padding: 15px 20px;
            border-left: 4px solid #2d5a99;
            margin: 20px 0;
            border-radius: 6px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 13px;
            color: #777;
        }

        .footer strong {
            color: #2d5a99;
        }

        .motivo {
            background: #fff6db;
            border-left: 4px solid #f1c40f;
            padding: 12px 20px;
            margin-top: 15px;
            border-radius: 6px;
        }

        .estado {
            background: #eaf4ec;
            border-left: 4px solid #27ae60;
            padding: 12px 20px;
            border-radius: 6px;
            margin-top: 20px;
        }

        .estado-expirada {
            background: #fdecea;
            border-left: 4px solid #e74c3c;
            padding: 12px 20px;
            border-radius: 6px;
            margin-top: 20px;
        }

        .header-logo {
            text-align: right;
            margin-bottom: 20px;
        }

        .header-logo img {
            height: 60px;
            opacity: 0.9;
        }
    </style>

</head>
<body>

<div class="container">

    {{-- LOGO SUPERIOR (opcional, si tienes uno de tu carrera/proyecto) --}}
    <div class="header-logo">
        {{-- <img src="{{ asset('images/logo_uta.png') }}" alt="Institución"> --}}
    </div>

    <h1>Notificación de Sanción</h1>

    <p>Estimado(a) <strong>{{ $user->persona->Nombre ?? $user->Email }}</strong>,</p>

    @if($tipo === 'asignada')
        <p>Se le informa que ha sido registrada una nueva sanción en el sistema de gestión de reservas de equipos.</p>
    @elseif($tipo === 'ampliada')
        <p>Su sanción vigente ha sido <strong>ampliada por 7 días adicionales</strong>.</p>
    @elseif($tipo === 'quitada')
        <p>Su sanción ha sido <strong>levantada</strong> y ya no registra restricciones activas.</p>
    @endif

    <div class="info-box">
        <h2>Detalles de la sanción</h2>
        <p><strong>Motivo:</strong> {{ $sancion->nivel }}</p>
        <p><strong>Fecha de inicio:</strong> {{ $sancion->fecha_inicio }}</p>
        <p><strong>Fecha de término:</strong> {{ $sancion->fecha_fin }}</p>
    </div>

    @if(isset($motivo) && $motivo !== null)
        <div class="motivo">
            <strong>Observación del administrador:</strong>
            <p>{{ $motivo }}</p>
        </div>
    @endif

    @if($sancion->estado === 'ACTIVA')
        <div class="estado">
            <strong>Estado actual:</strong> ACTIVA
        </div>
    @else
        <div class="estado-expirada">
            <strong>Estado actual:</strong> EXPIRADA
        </div>
    @endif

    <p>
        Por favor, respete las normas establecidas para el uso de los equipos e infraestructura.
        Ante cualquier duda, comuníquese con el administrador del laboratorio o la coordinación.
    </p>

    <div class="footer">
        <p>
            <strong>Departamento de Diseño Multimedia</strong><br>
            Universidad de Tarapacá – Sistema de Gestión de Préstamos<br>
            Este mensaje se ha generado automáticamente. No responda a este correo.
        </p>
    </div>

</div>

</body>
</html>
