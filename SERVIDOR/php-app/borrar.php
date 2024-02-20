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

// ESTOY BORRANDO
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'DELETE':
        $datos = json_decode(file_get_contents("php://input"), true);

        if (!isset($datos['id'])) {
            echo json_encode(['error' => 'Datos incompletos']);
            exit;
        }

        $id = $datos['id'];

        $consulta = $conexion->prepare("DELETE FROM personajes WHERE id = ?");
        $consulta->bind_param("i", $id);

        if ($consulta->execute()) {
            echo json_encode(['success' => true, 'message' => 'Personaje eliminado correctamente']);
        } else {
            echo json_encode(['error' => 'Error en la operación de la base de datos', 'sqlError' => $consulta->error]);
        }

        $consulta->close();
        break;
    case 'POST':
        // Maneja la solicitud POST
        echo json_encode(['message' => 'Método POST no implementado']);
        break;
    case 'GET':
        // Maneja la solicitud GET
        echo json_encode(['message' => 'Método GET no implementado']);
        break;
    case 'PUT':
        // Maneja la solicitud PUT
        echo json_encode(['message' => 'Método PUT no implementado']);
        break;
    default:
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode(['error' => 'Método no permitido']);
        break;
}

$conexion->close();
?>