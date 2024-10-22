<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/functions.js') }}" defer></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.css" rel="stylesheet">

    <!-- Add these lines to your layout or view -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/plugins/table/trumbowyg.table.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/plugins/upload/trumbowyg.upload.min.js"></script>

</head>

<body>
    <div id="wrapper">
        @if (auth()->user())
            @include('layouts.menu')
        @endif
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @if (auth()->user())
                    @include('layouts.topbar')
                @endif
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @yield('js')
            @include('layouts.footer')
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.editor').trumbowyg({
                minHeight: 200,
                plugins: {
                    // Habilitar plugins
                    table: true,
                    upload: {
                        serverPath: '/ruta/de/subida', // Ruta de tu backend
                        fileFieldName: 'image', // Nombre del campo de la imagen
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF si es necesario
                        },
                        urlPropertyName: 'file', // Nombre de la propiedad con la URL de la imagen
                    }
                },
                lang: 'es', // Idioma
                semantic: true, // Uso semántico del HTML

                // Configuración de la barra de herramientas
                btns: [
                    ['viewHTML'],
                    ['bold', 'italic', 'underline'],
                    ['alignLeft', 'alignCenter', 'alignRight'],
                    ['upload'], // Botón para subir imágenes
                    ['unorderedList', 'orderedList'],
                    ['image'], // Botón para insertar imágenes
                    ['table'], // Botón para insertar tablas
                    ['removeformat'],
                ],
            });

            $('table').DataTable({
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros por página",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                // Resto de las opciones del DataTable
            });
        });
    </script>

</body>

</html>
