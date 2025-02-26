<?php
session_start();

require_once __DIR__ . '/../model/Pasajero.php';
require_once __DIR__ . '/../database/funciones.php';

// Variables para almacenar errores
$id = $contra = $contra1 = $edad = $nombre = $apellidos = "";
$idErr = $edadErr = $nombreErr = $apellidosErr = $contraErr = $contra1Err = $contrasErr = "";
$errores = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación de datos
    if (!empty($_POST["id"])) {
        $id = ($_POST["id"]);
    } else {
        $idErr = "El ID es obligatorio";
        $errores = true;
    }

    if (!empty($_POST["contra"])) {
        $contra = ($_POST["contra"]);
    } else {
        $contraErr = "Tienes que introducir la contraseña";
        $errores = true;
    }

    if (!empty($_POST["contra1"])) {
        $contra1 = ($_POST["contra1"]);
    } else {
        $contra1Err = "Tienes que introducir de nuevo la contraseña";
        $errores = true;
    }

    if (!empty($_POST["edad"])) {
        $edad = ($_POST["edad"]);
    } else {
        $edadErr = "La edad es obligatoria";
        $errores = true;
    }

    if (!empty($_POST["nombre"])) {
        $nombre = ($_POST["nombre"]);
    } else {
        $nombreErr = "El nombre es obligatorio";
        $errores = true;
    }

    if (!empty($_POST["apellidos"])) {
        $apellidos = ($_POST["apellidos"]);
    } else {
        $apellidosErr = "Los apellidos son obligatorios";
        $errores = true;
    }
    $asistencia = isset($_POST["asistencia"]) ? true : false;
    // Validar si las contraseñas coinciden
    if ($contra !== $contra1) {
        $contrasErr = "
            <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>¡Error!</strong> Las contraseñas no coinciden.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        $errores = true;
    }

    // Si no hay errores, proceder con la inserción
    if (!$errores) {
        // Hashear la contraseña
        $_SESSION['user_id'] = $id; 

        // Crear el objeto Pasajero con los datos obtenidos del formulario
        $pasajero = new Pasajero($id, $nombre, $apellidos, $edad, $asistencia, $contra);


        // Verificar si el ID ya existe antes de insertar
        if (verificarId($id)) {
            insertarUsuario($pasajero); // Llamada a la función que inserta el usuario
            header("Location:");
            exit();
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>¡Error!</strong> Este usuario ya está en uso.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="">
    <title>Registro</title>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-75">
    <div class="card border bg-white p-4" style="width: 28rem;">
        <h3 class="text-center pt-3 font-weight-bold">Registro</h3>
        <form action="pasajero.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="id" class="form-label">ID de usuario:</label>
                <input type="text" class="form-control" name="id" id="id" value="<?= ($id); ?>">
                <small class="form-text text-danger"><?= $idErr; ?></small>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?= ($nombre); ?>">
                <small class="form-text text-danger"><?= $nombreErr; ?></small>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" name="apellidos" id="apellidos" value="<?= ($apellidos); ?>">
                <small class="form-text text-danger"><?= $apellidosErr; ?></small>
            </div>
            <div class="mb-3">
                <label for="edad" class="form-label">Edad:</label>
                <input type="number" class="form-control" name="edad" id="edad" value="<?= ($edad); ?>">
                <small class="form-text text-danger"><?= $edadErr; ?></small>
            </div>
            <div class="mb-3">
                <label for="contra" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" name="contra" id="contra">
                <small class="form-text text-danger"><?= $contraErr; ?></small>
            </div>

            <div class="mb-3">
                <label for="contra1" class="form-label">Repite la contraseña:</label>
                <input type="password" class="form-control" name="contra1" id="contra1">
                <small class="form-text text-danger"><?= $contra1Err; ?></small>
            </div>
            <div class="text-center pt-4 text-muted">
                ¿Ya tienes una cuenta? <a href="/trabajoPHP/inicio/login.php" class="text-primary">Login</a>
            </div>
            <?= $contrasErr; ?>

            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
        </form>
    </div>
</div>
</body>
</html>
