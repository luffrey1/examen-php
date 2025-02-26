<?php
session_start();

require_once __DIR__ . '/database/funciones.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /examen/formularios/pasajero.php");
    exit(); // Asegúrate de salir después de redirigir
} else {
    // Si el usuario está autenticado, acceder a la sesión
    $id = $_SESSION['user_id'];
   


}

// Manejar eliminación de pasajero
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    eliminarPasajero($id); // Llama a la función para eliminar el pasajero
    header("Location: index.php"); // Redirige después de eliminar
    exit();
}
$pasajeros = obtenerDatosPasajero(); // Obtiene todos los pasajeros

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Lista de Pasajeros</title>
</head>
<body>

<div class="container">
    <h1 class="mt-5">Lista de Pasajeros</h1>
        <?php foreach ($pasajeros as $pasajero): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">ID: <?= ($pasajero->getId()) ?></h5>
                    <p><strong>Nombre:</strong> <?= ($pasajero->getNombre()) ?></p>
                    <p><strong>Apellidos:</strong> <?= ($pasajero->getApellidos()) ?></p>
                    <p><strong>Edad:</strong> <?= ($pasajero->getEdad()) ?></p>
                    <p><strong>Asistencia:</strong> <?= ($pasajero->getAsistencia() ? "Sí" : "No") ?></p>
                    <div class="d-flex justify-content-between">
                        <a href="ajustes/editar.php?id=<?= ($pasajero->getId()) ?>" class="btn btn-primary" style="width:100px;">Editar</a>

                        <form method="GET" action="" onsubmit="return confirm('¿Seguro que deseas eliminar este pasajero?')">
                            <input type="hidden" name="id" value="<?= ($pasajero->getId()) ?>">
                            <button type="submit" class="btn btn-danger" style="width:100px;">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
</div>

</body>
</html>
