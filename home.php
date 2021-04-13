<?php
include "config.php";

// Check user login or not
if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
}

?>

<!doctype html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
</head>

<body>
    <nav class="navbar navbar-light bg-light justify-content-between">
        <a class="btn btn-outline-success" href="/upload.php">Registrar nueva imagen</a>

        <form class="form-inline" method='post' action="logout.php">
            <input class="btn btn-info" type="submit" value="Cerrar sesion" name="but_logout">
        </form>
    </nav>

    <h1>
        Catálogo imágenes
    </h1>
    <table id="tabla-imagenes" class="display">
        <thead>
            <tr>
                <th>Lengua</th>
                <th>Nombre</th>
                <th>Municipio</th>
                <th>Estado</th>
                <th>Imagen</th>
                <th>Subido por:</th>
                <th>Fecha de carga</th>

            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
</body>

<script type="text/javascript">
    $('#tabla-imagenes').DataTable({
        language: {
            url: '/dataTableSpanish.json'
        },

        ajax: '/apiFotos.php',
        dataSrc: '',
        columns: [{
                data: 'lengua'
            },
            {
                data: 'nombre'
            },
            {
                data: 'municipio'
            },
            {
                data: 'estado'
            },
            {
                data: 'ubicacion_foto',
                render: (data, type, row) => {
                    return `<a href="${data}" target="_blank">
                    <img src="${data}" style="max-width:50px; max-height=50px;"> 
                    </a>`
                }
            },
            {
                data: 'subido_por'
            },
            {
                data: 'created_at'
            }
        ]
    });
</script>

</html>