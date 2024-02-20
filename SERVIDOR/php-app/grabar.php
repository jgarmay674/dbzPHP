<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json'); // Establece la cabecera correcta para JSON

// Verifica si el método de la solicitud es OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Si es una solicitud OPTIONS, termina la ejecución del script enviando una respuesta de estado 200 (OK)
    http_response_code(200);
    exit;
}

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

// ESTOY GRABANDO
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'POST':
        // JSON enviado en el cuerpo de la solicitud POST
        $datos = json_decode(file_get_contents("php://input"), true);

        if (!isset($datos['nombre']) || !isset($datos['fuerza'])) {
            echo json_encode(['error' => 'Datos incompletos']);
            exit;
        }

        $nombre = $datos['nombre'];
        $fuerza = $datos['fuerza'];

        // Utiliza sentencias preparadas para prevenir inyección SQL
        $consulta = $conexion->prepare("INSERT INTO personajes (nombre, fuerza) VALUES (?, ?)");
        $consulta->bind_param("si", $nombre, $fuerza);

        if ($consulta->execute()) {
            echo json_encode(['success' => true, 'message' => 'Personaje agregado correctamente']);
        } else {
            echo json_encode(['error' => 'Error en la operación de la base de datos', 'sqlError' => $consulta->error]);
        }

        $consulta->close();
        break;
    case 'GET':
        // Maneja la solicitud GET
        echo json_encode(['message' => 'Método GET no implementado']);
        break;
    case 'PUT':
        // Maneja la solicitud PUT
        echo json_encode(['message' => 'Método PUT no implementado']);
        break;
    case 'DELETE':
        // Maneja la solicitud DELETE
        echo json_encode(['message' => 'Método DELETE no implementado']);
        break;
    default:
        // Método no soportado
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode(['error' => 'Método no permitido']);
        break;
}

$conexion->close();
?>