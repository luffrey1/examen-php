<?php
session_start();
require_once __DIR__ . '/../database/funciones.php'; 

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger el id y la contraseña del formulario
    $id = $_POST['id'];
    $contrasena = $_POST['contrasena'];

    // Verificar si el id existe y comprobar la contraseña
    if (verificarContraseña($id, $contrasena)) {
        $success = "Contraseña correcta.";
    } else {
        $error = "La contraseña es incorrecta.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobar Contraseña</title>
</head>
<body>
    <h3>Comprobar Contraseña</h3>

    <form action="" method="POST">
        <div>
            <label for="id">ID del Pasajero</label>
            <input type="text" id="id" name="id">
        </div>

        <div>
            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena">
        </div>

        <button type="submit">Comprobar</button>
    </form>

    <?php if ($success): ?>
        <div style="color: green;">
            <?= $success; ?>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div style="color: red;">
            <?= $error; ?>
        </div>
    <?php endif; ?>

</body>
</html>
