<?php
include "config.php";

// Check user login or not
if (!isset($_SESSION['uname'])) {
    header('Location: index.php');
}

$message = '';
if (isset($_POST['upload-btn']) && $_POST['upload-btn'] == 'Guardar') {
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // get details of the uploaded file
        $fileTmpPath = $_FILES['imagen']['tmp_name'];
        $fileName = $_FILES['imagen']['name'];
        $fileSize = $_FILES['imagen']['size'];
        $fileType = $_FILES['imagen']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // sanitize file-name
        $newFileName =  $fileName . '.' . $fileExtension;

        // check if file has one of the following extensions
        $allowedfileExtensions = array('jpg', 'jpeg', 'gif', 'png');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // directory in which the uploaded file will be moved
            $uploadFileDir = './static/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $message = 'Archivo guardado';

                //Obtenemos el id del pueblo seleccionado
                $lengua = $_POST['lengua'];
                $nombre = $_POST['nombre'];
                $estado = $_POST['estado'];
                $municipio = $_POST['municipio'];
                $sql = "SELECT id FROM lenguas WHERE lengua='" . $lengua . "' and nombre = '" . $nombre . "' and estado ='" . $estado . "' and municipio = '" . $municipio . "'";
                $result = mysqli_query($con, $sql);

                $row = $result->fetch_row();

                if (!empty($row)) {
                    $id_pueblo = $row[0];
                    $usuario = $_SESSION['uname'];

                    $sql = "insert into pueblo_foto(ubicacion_foto,id_pueblo,subido_por) values ('" . $dest_path . "', $id_pueblo, '" . $usuario . "')";
                    $result = mysqli_query($con, $sql);
                    if ($result) {
                        $message = 'Imagen guardada correctamente en <a href="' . $dest_path . '" target="_blank">' . $newFileName . '</a>';
                    } else {
                        $message = mysqli_error($con);
                    }
                } else {
                    $message = 'Opción de pueblo y lengua no encontrada';
                }
            } else {
                $message = 'Hubo un error al guardar el archivo en el servidor';
            }
        } else {
            $message = 'Tipo de archivo no permitido. Debe ser: ' . implode(',', $allowedfileExtensions);
        }
    } else {
        $message = 'No se proporcionó ningún archivo<br>';
    }
}
$_SESSION['message'] = $message;


?>
<!DOCTYPE html>
<html>

<head>
    <title>Subir imagen</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-light bg-light justify-content-between">
        <a class="btn btn-outline-success" href="/home.php">Catalogo de imágenes</a>

        <form class="form-inline" method='post' action="logout.php">
            <input class="btn btn-info" type="submit" value="Cerrar sesion" name="but_logout">
        </form>
    </nav>


    <div class="container">
        <div class="jumbotron">


            <form name="uploadForm" action="upload.php" method="post" enctype="multipart/form-data" onsubmit="return validarForm();">
                <div class="form-group">
                    <select onchange="changeLengua(this.value)" id="select-lengua" name="lengua" class="custom-select">
                        <option value="-1">Seleccionar Lengua</option>
                    </select>
                </div>
                <div class="form-group">
                    <select onchange="changeNombre(this.value)" id="select-nombre" name="nombre" class="custom-select">
                        <option value="-1">Seleccionar Nombre</option>
                    </select>
                </div>
                <div class="form-group">
                    <select onchange="changeEstado(this.value)" id="select-estado" name="estado" class="custom-select">
                        <option value="-1">Seleccionar Estado</option>
                    </select>
                </div>
                <div class="form-group">
                    <select id="select-municipio" name="municipio" class="custom-select">
                        <option value="-1">Seleccionar Municipio</option>
                    </select>
                </div>

                <label for="imagen">Seleccionar foto</label>
                <input type="file" name="imagen" />
                <input type="submit" name="upload-btn" value="Guardar" />
            </form>

            <div id="message" class="alert alert-warning" role="alert" hidden>
                <?php
                if (isset($_SESSION['message']) && $_SESSION['message']) {
                    printf('<b>%s</b>', $_SESSION['message']);
                    unset($_SESSION['message']);
                }
                ?>
            </div>


        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>

<script type="text/javascript">
    $(document).ready(function() {
        messageDiv = document.getElementById('message')
        if (messageDiv.textContent.trim())
            messageDiv.removeAttribute('hidden')

        let option = "lengua";
        let select_menu = $('#select-lengua')[0]; // this expression is same as document.getElementById('dynamic_menu')
        $.ajax({
            url: "api.php",
            dataType: "json",
            method: "post",
            data: {
                option
            },
            success: function(response) {
                //alert(response.length);
                console.log($.isArray(response)); // if response is an array, this function will return true

                response.forEach((item, index) => {

                    var option = document.createElement("option");
                    option.value = item;
                    option.text = item;
                    select_menu.appendChild(option);
                })
            },
            error: error => {
                console.error(error)
            }
        })
    });


    function changeLengua(lengua) {
        let option = "nombre_lengua";
        let nombreLengua = $('#select-nombre')[0];

        //Removing all the old options from item list and model list and adding only one option in one go
        $('#select-nombre').empty().append('<option value="-1">Seleccionar Nombre</option>');
        $('#select-estado').empty().append('<option value="-1"> Seleccionar Estado</option>');
        $('#select-municipio').empty().append('<option value="-1">Seleccionar Municipio</option>');

        $.ajax({
            url: "api.php",
            dataType: "json",
            method: "post",
            data: {
                option,
                lengua
            },
            success: function(response) {
                response.forEach(item => {
                    // console.log(index, item);
                    var option = document.createElement("option");
                    option.value = item
                    option.text = item
                    nombreLengua.appendChild(option)
                })
            },
            error: err => console.error(err)
        })
    }

    //Getting model list on the basis of item id
    function changeNombre(nombre) {
        let option = "estado";
        let selectEstado = $('#select-estado')[0];
        const lengua = document.getElementById('select-lengua').value

        //Removing all the select options and adding only one option in one go
        $('#select-estado').empty().append('<option value="-1">Seleccionar Estado</option>');
        $('#select-municipio').empty().append('<option value="-1">Seleccionar Municipio</option>');

        $.ajax({
            url: "api.php",
            dataType: "json",
            method: "post",
            data: {
                option,
                nombre,
                lengua
            },
            success: function(response) {
                response.forEach(estado => {
                    //console.log(index,item);
                    var option = document.createElement("option");
                    option.value = estado
                    option.text = estado
                    selectEstado.appendChild(option);
                })
            }
        })
    }

    //Getting model list on the basis of item id
    function changeEstado(estado) {
        let option = "municipio";
        let selectMunicipio = $('#select-municipio')[0];
        const lengua = document.getElementById('select-lengua').value
        const nombre = document.getElementById('select-nombre').value
        //Removing all the select options and adding only one option in one go
        $('#select-municipio').empty().append('<option value="-1">Seleccionar Municipio</option>');

        $.ajax({
            url: "api.php",
            dataType: "json",
            method: "post",
            data: {
                option,
                lengua,
                nombre,
                estado
            },
            success: function(response) {
                response.forEach(municipio => {
                    //console.log(index,item);
                    var option = document.createElement("option");
                    option.value = municipio
                    option.text = municipio
                    selectMunicipio.appendChild(option);
                })
            },
            error: err => console.error(err)
        })
    }

    function validarForm() {
        if (document.getElementById('select-lengua').value == '-1') {
            document.getElementById('message').removeAttribute('hidden')
            document.getElementById('message').textContent = 'Debes seleccionar una lengua'
            return false
        }

        if (document.getElementById('select-nombre').value == '-1') {
            document.getElementById('message').removeAttribute('hidden')
            document.getElementById('message').textContent = 'Debes seleccionar el nombre de una lengua'
            return false
        }
        if (document.getElementById('select-estado').value == '-1') {
            document.getElementById('message').removeAttribute('hidden')
            document.getElementById('message').textContent = 'Debes seleccionar un estado'
            return false
        }
        if (document.getElementById('select-municipio').value == '-1') {
            document.getElementById('message').removeAttribute('hidden')
            document.getElementById('message').textContent = 'Debes seleccionar un municipio'
            return false
        }

        const fileName = document.forms['uploadForm']['imagen'].value
        const allowedExtensions = ['jpg', 'jpeg', 'JPG', 'JPEG', 'png', 'PNG']
        if (!fileName) {
            document.getElementById('message').removeAttribute('hidden')
            document.getElementById('message').textContent = 'Debes seleccionar una foto'
            return false
        }

        const fileExtension = fileName.split(".").pop()
        if (!allowedExtensions.includes(fileExtension)) {
            document.getElementById('message').removeAttribute('hidden')
            document.getElementById('message').textContent = 'Debes seleccionar una imagen válida'
            return false
        }

        return true
    }
</script>

</html>