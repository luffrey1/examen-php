<?php
require_once __DIR__ . '/../database/funciones.php';
session_start(); // Asegúrate de iniciar la sesión

if (isset($_POST['id'])) {
 
    $id = $_POST['id'];
    
    
    $_SESSION['idPasajeroEliminar'] = $id;

   
    $conexion = conectar();

    
    $sql = "DELETE FROM Pasajero WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('s', $id);
    $stmt->execute();

    // Limpiar la sesión después de eliminar
    unset($_SESSION['idPasajeroEliminar']);

    
    header("Location: /examen/index.php");
    exit(); 
}
?>
