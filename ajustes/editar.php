<?php
session_start();
require_once __DIR__ . '/../database/funciones.php'; // Archivo con las funciones necesarias

// Verificar si hay sesión activa
if (!isset($_SESSION['user_id'])) {
    echo "No tienes permisos para editar este pasajero.";
    exit();
}

// Obtener el ID del pasajero desde GET
$user_id = isset($_GET['id']) ? $_GET['id'] : null;

// Obtener datos del pasajero
$pasajero = obtenerDatosPasajeroId($user_id);

// Verificar si el pasajero existe
if ($pasajero === null) {
    echo "Pasajero no encontrado.";
    exit();
}

// Obtener la lista de aviones disponibles
$aviones = obtenerAviones();

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $edad = $_POST['edad'];
    $asistencia = isset($_POST['asistencia']) ? 1 : 0;
    $avion_id = $_POST['avion_id']; // Nuevo campo para el avión seleccionado

    // Actualizar el pasajero en la base de datos
    actualizarPasajero($id, $nombre, $apellidos, $edad, $asistencia, $avion_id);

    // Redirigir al índice
    header('Location: /index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
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
            <input type="text" id="id" name="id" value="<?= $pasajero->getId() ?>" readonly>
        </div>

        <div>
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?= $pasajero->getNombre() ?>">
        </div>

        <div>
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" value="<?= $pasajero->getApellidos() ?>">
        </div>

        <div>
            <label for="edad">Edad</label>
            <input type="number" id="edad" name="edad" value="<?= $pasajero->getEdad() ?>">
        </div>

        <div>
            <label for="asistencia">¿Necesita asistencia?</label>
            <input type="checkbox" id="asistencia" name="asistencia" <?= $pasajero->getAsistencia() ? 'checked' : ''; ?>>
        </div>

        <div>
            <label for="avion_id">Avión</label>
            <select id="avion_id" name="avion_id">
                <option value="">Selecciona un avión</option>
                
                <?php foreach ($aviones as $avion): ?>
                    
                    <option value="<?= $avion['id'] ?>" <?= ($pasajero->getAvionId() == $avion['id']) ? 'selected' : '' ?>>
                        <?= $avion['marca'] . " " . $avion['modelo'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>
