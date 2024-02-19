<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json'); // Establece la cabecera correcta para JSON

define("HOSTNAME", "localhost");
define("USERNAME", "id21568362_root");
define("PASSWORD", "CPIFPdwec-123");
define("DATABASE", "id21568362_dbzdb"); // utf8_spanish2_ci

$conexion = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

if (!$conexion) {
    // Devuelve un error si no se puede establecer la conexión
    echo json_encode(['error' => 'Error al conectar a la base de datos']);
    exit;
}

// ESTOY LEYENDO
$consulta = "SELECT * FROM personajes";
$resultado = mysqli_query($conexion, $consulta);

if (!$resultado) {
    // Devuelve un error si la consulta falla
    echo json_encode(['error' => 'Error en la consulta a la base de datos']);
    exit;
}

$datos = [];
while ($fila = mysqli_fetch_assoc($resultado)) { // Usa mysqli_fetch_assoc para obtener un array asociativo
    $datos[] = $fila; // Es equivalente a array_push, pero más limpio
}

echo json_encode($datos);

mysqli_free_result($resultado); // Libera la memoria asociada al resultado
mysqli_close($conexion);
?>