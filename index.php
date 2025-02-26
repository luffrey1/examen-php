<?php
session_start();

require_once __DIR__ . '/database/funciones.php';
if (!isset($_SESSION['user_id'])) {
    echo "No ha iniciado sesión.";
    header("Location: /examen/formularios/pasajero.php");
} else {
    // Si el usuario está autenticado, acceder a la sesión
    $user_id = $_SESSION['user_id'];

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <title>Bootstrap5</title>

</head>
<body>

<?php
mostrarPasajeros();
?>
</body>
</html>
