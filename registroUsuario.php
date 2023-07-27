<?php
require_once "CAD.php";

if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['celular']) && 
isset($_POST['estado']) && isset($_POST['pais']) && isset($_POST['ocupacion']) && isset($_POST['LugarTrabajo']) &&  
isset($_POST['Colegio']) && isset($_POST['correo']) && isset($_POST['contraseña']) && isset($_FILES['certificado']) && isset($_FILES['comprobante'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $contraseña = password_hash($contraseña, PASSWORD_DEFAULT);
    $celular = $_POST['celular'];
    $estado = $_POST['estado'];
    $pais = $_POST['pais'];
    $ocupacion = $_POST['ocupacion'];
    $colegio = $_POST['Colegio'];
    $LugarTrabajo = $_POST['LugarTrabajo'];

    
    $carpeta_destino_Certificados = "Certificados/"; // Ruta donde se guardará el certificado
    $carpeta_destino_Comprobantes = "Comprobantes/"; // Ruta donde se guardará el comprobante


    // Procesar el certificado subido
    $Certificado = basename($_FILES['certificado']['name']);
    $extension_Certificado = strtolower(pathinfo($Certificado, PATHINFO_EXTENSION));

    // Procesar el comprobante subido
    $Comprobante = basename($_FILES['comprobante']['name']);
    $extension_Comprobante = strtolower(pathinfo($Comprobante, PATHINFO_EXTENSION));

    if (($extension_Certificado == "pdf" || $extension_Certificado == "doc" || $extension_Certificado == "docx" || $extension_Certificado == "jpg") &&
        ($extension_Comprobante == "pdf" || $extension_Comprobante == "doc" || $extension_Comprobante == "docx" || $extension_Comprobante == "jpg")) {

        if (move_uploaded_file($_FILES['certificado']['tmp_name'], $carpeta_destino_Certificados . $Certificado) && 
            move_uploaded_file($_FILES['comprobante']['tmp_name'], $carpeta_destino_Comprobantes . $Comprobante)) {
            // Los archivos se han subido correctamente, ahora puedes continuar con el registro del usuario
            $cad = new CAD();

            if ($cad->verificaCorreoRegistrado($correo)) {
                echo "El correo ya está registrado";
            } else {
                $cad->agregaUsuario($nombre, $apellido, $contraseña, $correo, $Certificado, $Comprobante, $celular, $estado, $pais, $ocupacion, $LugarTrabajo, $colegio);
            }
        } else {
            echo "Error al subir el archivo.";
        }
    } else {
        echo "Error al subir los archivos, las extensiones no son correctas.";
    }
}

unset($_POST['nombre']);
unset($_POST['apellido']);
unset($_POST['correo']);
unset($_POST['contraseña']);
unset($_POST['celular']);
unset($_POST['estado']);
unset($_POST['pais']);
unset($_POST['ocupacion']);
unset($_POST['colegio']);
unset($_POST['LugarTrabajo']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro USUARIO</title>
    <link rel="stylesheet" href="http://localhost/PROYDIEGO/css/registroEstilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <div class="formulario">
        <h1>Registro de USUARIO</h1>
        <form action="registroUsuario.php" method="POST" enctype="multipart/form-data">
            <span>Nombre:</span>
            <input type="text" name="nombre" required>
            <span>Apellido:</span>
            <input type="text" name="apellido" required>
            <span>Correo:</span>
            <input type="text" name="correo" required>
            <span>Contraseña:</span>
            <input type="password" name="contraseña" required>
            <span>Celular:</span>
            <input type="tel" name="celular" required>
            <span>Estado:</span>
            <input type="text" name="estado" required>
            <span>Pais:</span>
            <input type="text" name="pais" required>
            <span>Ocupacion:</span>
            <input type="text" name="ocupacion" required>
            <span>Lugar Trabajo:</span>
            <input type="text" name="LugarTrabajo" required>
            <span>Colegio:</span>
            <input type="text" name="Colegio" required>
            <div class="col-12">
                        <label for="yourPassword" class="form-label">Certificado de Socio (JPG & PDF)</label>
                        <input type="file" name="certificado" id="certificado" class="form-control" required>
            </div>
            <div class="col-13">
                        <label for="yourPassword" class="form-label">Comprobante de pago (JPG & PDF)</label>
                        <input type="file" name="comprobante" id="comprobante" class="form-control" required>
            </div>

            <input type="submit" value="Registrate">
        </form>
        <div class="registrarse">
            ¿Ya tienes una cuenta? <a href="http://localhost/Proyecto/bd/inicioSesion.php">Inicia sesión</a>
        </div>
    </div>
</body>
</html>