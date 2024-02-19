<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json'); // Establece la cabecera correcta para JSON

define("HOSTNAME", "db");
define("USERNAME", "root");
define("PASSWORD", "dejame");
define("DATABASE", "dbzDB"); // utf8_spanish2_ci

$conexion = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

if (!$conexion) {
    // Devuelve un error si no se puede establecer la conexión
    echo json_encode(['error' => 'Error al conectar a la base de datos']);
    exit;
}

// JSON enviado en el cuerpo de la solicitud POST
$datos = json_decode(file_get_contents("php://input"), true);

// Ahora puedes acceder a $datos como un array asociativo
if (!isset($datos['id'])) {
    echo json_encode(['error' => 'Datos incompletos']);
    exit;
}

// ESTOY GRABANDO
$id = $datos['id'];

// Utiliza sentencias preparadas para mayor seguridad
$consulta = $conexion->prepare("DELETE FROM personajes WHERE id = ?");
$consulta->bind_param("i", $id);

if ($consulta->execute()) {
    // Consulta exitosa
    echo json_encode(['success' => true, 'message' => 'Personaje agregado correctamente']);
} else {
    // Error al ejecutar la consulta
    echo json_encode(['error' => 'Error en la operación de la base de datos', 'sqlError' => $consulta->error]);
}

$consulta->close();
$conexion->close();
?>