<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>GRES: {{ $buque->nombre_proyecto }}</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100vh;
            position: relative;
            margin-top: 80px;
        }
        .background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ public_path('storage/images/aaaa.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            z-index: -1;
        }
        .header, .footer {
            width: 100%;
            text-align: center;
            position: fixed;
            z-index: 2;
        }
        .header {
            top: 0;
        }
        .footer {
            bottom: 0;
        }
        .page-break {
            page-break-after: always;
        }
        .content {
            padding: 50px; /* Usamos padding en lugar de margin para aplicar margen interno */
            page-break-inside: avoid;
            position: relative;
            z-index: 1;
            box-sizing: border-box; /* Para asegurarnos de que el padding esté dentro del área del contenido */
        }
        .cover-page {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            z-index: 1;
            margin-top: 50%;
        }
        .cover-page h1 {
            color: #1c345c;
        }
        h2, p {
            margin: 0 0 10px 0;
            word-wrap: break-word;
        }
        .collaborators {
            margin-top: 20px;
            text-align: center;
        }
        .collaborators p {
            font-size: 14px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="background"></div>
    
    <!-- Primera página con solo el título -->
    <div class="cover-page">
        <h1>ANEXO GRES: {{ $buque->nombre_proyecto }}</h1>
        <div class="collaborators">
            @foreach ($buque->colaboradores as $colaborador)
                <h3>{{ $colaborador->col_cargo }} {{ $colaborador->col_nombre }} {{ $colaborador->col_entidad }}</h3>
            @endforeach
        </div>
    </div>

    <div class="page-break"></div> 

    <div class="content">
        @foreach($sistemasEquipos as $equipo)
            <div>
                <h2>{{ $equipo['mfun'] }}: {{ $equipo['titulo'] }}</h2>
                <p>MEC: {{ $equipo['pivot']['mec'] }}</p>
                <p>Observaciones Generales: {{ $equipo['pivot']['observaciones'] }}</p>
                @if(!empty($equipo['pivot']['base64Image']))
                    <div class="image-container">
                        <img src="{{ $equipo['pivot']['base64Image'] }}" alt="Diagrama de {{ $equipo['titulo'] }}" style="width: 100%; max-width: 600px; height: auto; margin-top: 10px;">
                    </div>
                @endif
                <h3>Observaciones Detalladas:</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pregunta</th>
                            <th>Observación</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($observacionesPorEquipo[$equipo['id']]))
                            @foreach($observacionesPorEquipo[$equipo['id']] as $pregunta => $observacion)
                                <tr>
                                    <td>{{ $preguntasMap[$pregunta] }}</td>
                                    <td>{{ $observacion }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2">No hay observaciones.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="page-break"></div>
            </div>
        @endforeach
    </div>
</body>
</html>
