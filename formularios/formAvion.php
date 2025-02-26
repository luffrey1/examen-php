<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/database/funciones.php';
// crearTablaAvion();
// crearTablaPasajero();
$marca = $modelo = $maximoPasajeros = "";
$marcaErr = $modeloErr = $maximoPasajerosErr ="";
$errores = false;
$notificacionEx='';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(!empty($_POST["marca"])) {
        //Si ha rellenado el nombre
        $marca = $_POST["marca"];
       } else {
        $marcaErr = "La marca es obligatoria";
        $errores = true;
       }
       if(!empty($_POST["modelo"])) {
        //Si ha rellenado el nombre
        $modelo = $_POST["modelo"];
       } else {
        $modeloErr = "EL modelo es obligatoria";
        $errores = true;
       }
       if(!empty($_POST["maximoPasajeros"])) {
        //Si ha rellenado el nombre
        $maximoPasajeros = $_POST["maximoPasajeros"];
       } else {
        $maximoPasajerosErr = "El maximo es obligatoria";
        $errores = true;
       }
    
       if ($errores) {
        $notificacionErr = "<div class='alert alert-danger alerta'>No enviado.</div>";
    }else{
        $notificacionEx = "<div class='alert alert-success alerta2'>Subido.</div>";
        // Crear el objeto avion
        $avion = new Avion(
        $marca,
        $modelo,
        $maximoPasajeros,
        [],
        );

        // Insertar el coche en la base de datos
        if (insertarAvion($avion)) {
        echo "Avion registrado con éxito.";
        } else {
        echo "Error al registrar el Avion.";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link rel="stylesheet" href=../views/formCoche.css>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   <title>FormularioCoche</title>
</head>
<style>

   </style>
<body>


<?php
    if ($errores) {
        echo $notificacionErr;
    } else if ($errores!=true) {
        echo $notificacionEx;
    }
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <form action="formAvion.php" method="POST" enctype="multipart/form-data" class="vehiculo p-4 bg-light rounded shadow w-100">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="marca" class="form-label">Marca: *</label>
                <input type="text" class="form-control" maxlength="7" size="7" name="marca" value="<?php echo $marca; ?>">
                <span class="errores"><?php echo $marcaErr; ?></span>
            </div>
            <div class="col-md-6">
                <label for="color" class="form-label">modelo: *</label>
                <input type="text" name="modelo" class="form-control" value="<?php echo $modelo; ?>">
                <span class="errores"><?php echo $modeloErr; ?></span>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="maximoPasajeros" class="form-label">Número maximo de Pasajeros: *</label>
                <input type="number" name="maximoPasajeros" class="form-control" value="<?php echo $maximoPasajeros; ?>">
                <span class="errores"><?php echo $maximoPasajerosErr; ?></span>
            </div>
        <button type="submit" class="btn btn-primary w-100">Añadir Avion</button>
    </form>
</div>


</body>
</html>