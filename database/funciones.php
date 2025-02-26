<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/examen/model/Avion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/examen/model/Pasajero.php';
function conectar() {
    $server = "127.0.0.1"; // localhost
    $user = "root";
    $pass = "1234"; //1234
    $dbname = "daw";
    return new mysqli($server, $user, $pass, $dbname);
}
function crearTablaAvion() {
    $conexion = conectar();
    $sql = "CREATE table if not exists Avion (
    id INT AUTO_INCREMENT PRIMARY KEY not null,
    marca varchar(200) not null,
    modelo varchar(200) not null,
    maximoPasajeros int not null

    )";
    $conexion->query($sql);
}
function crearTablaPasajero() {
    $conexion = conectar();
    $sql = "CREATE TABLE if not exists Pasajero (
    id VARCHAR(50) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    edad INT NOT NULL,
    asistencia BOOLEAN NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    avion_id INT,
    FOREIGN KEY (avion_id) REFERENCES Avion(id) ON DELETE CASCADE
)";
$conexion->query($sql);
}

function guardar() {
    $conexion = conectar();
    $sqlAviones = "INSERT INTO Avion (marca, modelo, maximoPasajeros) VALUES
        ('Airbus', 'A320', 180),
        ('Boeing', '747', 400),
        ('Embraer', 'E190', 120)";
   $sqlPasajeros = "INSERT INTO Pasajero (id, nombre, apellidos, edad, asistencia, contrasena, avion_id) VALUES
   ('P001', 'Juan', 'Pérez', 30, TRUE, '" . password_hash('clave1', PASSWORD_DEFAULT) . "', 1),
   ('P002', 'Ana', 'Gómez', 25, FALSE, '" . password_hash('clave2', PASSWORD_DEFAULT) . "', 1),
   ('P003', 'Carlos', 'López', 40, TRUE, '" . password_hash('clave3', PASSWORD_DEFAULT) . "', 2),
   ('P004', 'María', 'Fernández', 35, FALSE, '" . password_hash('clave4', PASSWORD_DEFAULT) . "', 3)";
   $conexion->query($sqlAviones);
   $conexion->query($sqlPasajeros);
}
function insertarAvion($avion) {
    $conexion = conectar();
    $sql = "INSERT INTO Avion (marca,modelo,maximoPasajeros) 
    VALUES (?, ?, ?)";
    $ps = $conexion->prepare($sql);
    $marca = $avion->getMarca();
    $modelo = $avion->getModelo();
    $maximoPasajeros = $avion->getMaximoPasajeros();

    $ps->bind_param(
        'ssi',
        $marca, $modelo, $maximoPasajeros
    );
    $ps->execute();
    $avionId = $conexion->insert_id;
    $avion->setId($avionId);
}
function insertarUsuario($pasajero) {
    $conexion = conectar();
    $sql = "INSERT INTO Pasajero (id, nombre, apellidos, edad, asistencia, contrasena) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $prepared = $conexion->prepare($sql);

    // Obtener los valores del objeto Pasajero
    $id = $pasajero->getId();
    $nombre = $pasajero->getNombre();
    $apellidos = $pasajero->getApellidos();
    $edad = $pasajero->getEdad();
    $asistencia = $pasajero->getAsistencia();
    $avion_id = $pasajero->getAvionId(); // Agregar avion_id al objeto
    
    // Hashear la contraseña
    $pass = password_hash($pasajero->getContrasena(), PASSWORD_DEFAULT);

    // Vincular parámetros al query
    $prepared->bind_param(
        "issibsi", 
        $id,
        $nombre,
        $apellidos,
        $edad,
        $asistencia,
        $pass,
        $avion_id
    );
    
    // Ejecutar la consulta
    $prepared->execute();
}

function obtenerAviones() {
    $conexion = conectar(); // Establecer la conexión con la base de datos
    $sql = "SELECT id, marca, modelo FROM Avion"; // Consulta SQL para obtener los aviones
    $resultado = $conexion->query($sql); // Ejecutar la consulta
    
    $aviones = [];
    
    if ($resultado->num_rows > 0) {
        // Guardar los aviones en un array
        while ($fila = $resultado->fetch_assoc()) {
            $aviones[] = $fila; // Cada avión será un array con 'id', 'marca' y 'modelo'
        }
    }
    
    return $aviones; // Devolver el array de aviones
}

function verificarId($id):bool {
    $conexion = conectar();
    $sql = "SELECT * from Pasajero where id = ?";
    $prepared = $conexion->prepare($sql);
    $prepared->bind_param("s", $id);
    $prepared->execute();
    $resultado = $prepared->get_result();
    if ($resultado->num_rows > 0) { 
        return false;
    } else {
        return true;
    }
    return null; // Return null if tipo is not 'c' or 'm'
}
function eliminarPasajero($id) {
    $conexion = conectar(); // Conectar a la base de datos

    $sql = "DELETE FROM Pasajero WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('s', $id);

    if ($stmt->execute()) {
        $stmt->close();
        $conexion->close();
        return true; // Eliminación exitosa
    } else {
        $stmt->close();
        $conexion->close();
        return false; // Error al eliminar
    }
}
function obtenerDatosPasajero() {
    // Conexión a la base de datos
    $conexion = conectar();

    // Consulta SQL para obtener todos los datos de los pasajeros
    $sql = "SELECT id, nombre, apellidos, edad, asistencia FROM Pasajero";

    // Preparar la consulta
    $prepared = $conexion->prepare($sql);

    // Ejecutar la consulta
    $prepared->execute();

    // Obtener el resultado
    $result = $prepared->get_result();

    $pasajeros = []; // Array para almacenar los pasajeros

    // Recuperar todos los datos de los pasajeros
    while ($data = $result->fetch_assoc()) {
        // Crear un objeto Pasajero por cada fila obtenida
        $pasajeros[] = new Pasajero(
            $data['id'], 
            $data['nombre'], 
            $data['apellidos'], 
            (int)$data['edad'], 
            (bool)$data['asistencia'],
            ''
        );
    }

    // Devolver el array de pasajeros (puede estar vacío si no hay registros)
    return $pasajeros; 
}

function obtenerDatosPasajeroId($id) {
    // Conexión a la base de datos
    $conexion = conectar();

    // Consulta SQL para obtener los datos del pasajero
    $sql = "SELECT id, nombre, apellidos, edad, asistencia, avion_id FROM Pasajero WHERE id = ?";

    // Preparar la consulta
    $prepared = $conexion->prepare($sql);
    if ($prepared === false) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    // Vincular el parámetro
    $prepared->bind_param("s", $id); 

    // Ejecutar la consulta
    $prepared->execute();

    // Obtener el resultado
    $result = $prepared->get_result();

    // Recuperar los datos del pasajero
    $data = $result->fetch_assoc();

    if ($data) {
        // Devolver un objeto Pasajero con los datos obtenidos
        return new Pasajero(
            $data['id'], 
            $data['nombre'], 
            $data['apellidos'], 
            (int)$data['edad'], 
            (bool)$data['asistencia'],
            '', // aqui va la contraseña
            (int)$data['avion_id']
        );
    }
    
    // Si no se encontró el pasajero, devolver null
    return null; 
}
function actualizarPasajero($id, $nombre, $apellidos, $edad, $asistencia, $avion_id) {
    $conexion = conectar();


    $sql = "UPDATE Pasajero 
            SET nombre = ?, apellidos = ?, edad = ?, asistencia = ?, avion_id = ?  
            WHERE id = ?";

    $stmt = $conexion->prepare($sql);

    $stmt->bind_param("ssdiis", $nombre, $apellidos, $edad, $asistencia, $avion_id, $id);
    $resultado = $stmt->execute();
    if ($resultado) {
        echo "Los datos del pasajero han sido actualizados correctamente.";
    } else {
        echo "Error al actualizar los datos del pasajero: " . $stmt->error;
    }
    $stmt->close();
    $conexion->close();
}
function verificarUsuario( $id, $contra) {


    $conexion = conectar();


    $sql = "SELECT contrasena FROM Pasajero WHERE id = ?";
    $prepared = $conexion->prepare($sql);
    $prepared->bind_param("s", $id);
    $prepared->execute();
   
    $result = $prepared->get_result();


    if ($result->num_rows > 0) {
        $fila = $result->fetch_assoc();
        $hash = $fila["contrasena"];
        return password_verify($contra, $hash);
    }


    return false;

}






