<?php
session_start();
require_once __DIR__ . '/../database/funciones.php'; // Asegúrate de que este archivo existe y está correctamente configurado

// Verificar si hay sesión y obtener el id del usuario
if (!isset($_SESSION['user_id'])) {
    echo "No tienes permisos para editar este pasajero.";
    exit();
}

// Recuperar el id del usuario desde la sesión
$user_id = isset($_GET['id']) ? $_GET['id'] : null;

// Obtener los datos del pasajero desde la base de datos
$pasajero = obtenerDatosPasajeroId($user_id);

// Verificar si el pasajero existe
if ($pasajero === null) {
    echo "Pasajero no encontrado.";
    exit();
}

// Definir las variables
$nombre = $apellidos = $edad = $asistencia = "";

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $edad = $_POST['edad'];
    $asistencia = isset($_POST['asistencia']) ? 1 : 0; // Si 'asistencia' está marcado, se pone 1, sino 0

    // Actualizar el pasajero en la base de datos
    actualizarPasajero($id, $nombre, $apellidos, $edad, $asistencia);

    // Redirigir al índice
    header('Location: /index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pasajero</title>
</head>
<body>
    <h3>Editar Pasajero</h3>

    <form action="" method="POST">
        <div>
            <label for="id">ID</label>
            <input type="text" id="id" name="id" value="<?= ($pasajero->getId()) ?>" readonly>
        </div>

        <div>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?= ($pasajero->getNombre()) ?>">
        </div>

        <div>
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" value="<?= ($pasajero->getApellidos()) ?>">
        </div>

        <div>
            <label for="edad">Edad</label>
            <input type="number" id="edad" name="edad" value="<?= ($pasajero->getEdad()) ?>">
        </div>

        <div>
            <label for="asistencia">¿Necesita asistencia?</label>
            <input type="checkbox" id="asistencia" name="asistencia" <?= $pasajero->getAsistencia() ? 'checked' : ''; ?>>
        </div>

        <button type="submit">Editar</button>
    </form>
</body>
</html>
