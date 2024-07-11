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
            background-image: url('{{ public_path('storage/images/BackgroundPDF.png') }}');
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
            padding: 50px;
            page-break-inside: avoid;
            position: relative;
            z-index: 1;
            box-sizing: border-box;
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
        h2, p, h3 {
            margin: 0 0 10px 0;
            word-wrap: break-word;
            color: #1c345c;
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
            font-size: 12px; /* Letra más pequeña */
        }
        .table th {
            background-color: #1c345c;
            color: white;
            text-align: left;
        }
        .table td:first-child {
            width: 10%; /* Columna de pregunta más pequeña */
        }
        .table td:last-child {
            width: 90%; /* Columna de observación más ancha */
        }
        .image-container {
            margin-top: 10px;
            text-align: left; /* Orienta la imagen a la izquierda */
            margin-bottom: 10px;
        }
        .image-container img {
            width: 65%; /* Ajusta el tamaño según tus necesidades */
            height: auto;
            border: 1px solid #1c345c; /* Borde de color #1c345c */
        }
    </style>
</head>
<body>
    <div class="background"></div>
    
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
                <h3>{{ $equipo['mfun'] }}: {{ strtoupper($equipo['titulo']) }}</h3>
                <h3>{{ $equipo['pivot']['mec'] }}</h3>
                <p>Diagrama de decisiones:</p>
                @if(!empty($equipo->pivot->image))
                    <div class="image-container">
                        
                        <img src="{{ $equipo->pivot->image }}" alt="Diagrama de {{ $equipo['titulo'] }}">
                    </div>
                @else
                    <p>No hay imagen disponible para este diagrama.</p>
                @endif
                <p>Observaciones Detalladas:</p>
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
