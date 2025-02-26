<?php
session_start();


require_once $_SERVER['DOCUMENT_ROOT'] . '/database/funciones.php';
// Variables para almacenar errores
$id = $contra = "";
$idErr = $contraErr = "";
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

    // Si no hay errores, proceder con la verificación
    if (!$errores) {
        // Verificar el usuario
        if (verificarUsuario($id, $contra)) {
            // Almacenar el ID en la sesión
            $_SESSION['user_id'] = $id; 
            // Redirigir a la página principal o a la página de pasajeros
            header("Location: /../index.php"); 
            exit();
        } else {
            $contraErr = "ID o contraseña incorrectos";
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
    <title>Login</title>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-75">
    <div class="card border bg-white p-4" style="width: 28rem;">
        <h3 class="text-center pt-3 font-weight-bold">Iniciar Sesión</h3>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="id" class="form-label">ID de usuario:</label>
                <input type="text" class="form-control" name="id" id="id" value="<?= htmlspecialchars($id); ?>">
                <small class="form-text text-danger"><?= $idErr; ?></small>
            </div>
            <div class="mb-3">
                <label for="contra" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" name="contra" id="contra">
                <small class="form-text text-danger"><?= $contraErr; ?></small>
            </div>
            <div class="text-center pt-4 text-muted">
                ¿No tienes una cuenta? <a href="/trabajoPHP/inicio/pasajero.php" class="text-primary">Registrate</a>
            </div>

            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>
    </div>
</div>
</body>
</html>
