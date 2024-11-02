<?php
// Mostrar todos los errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

// Your PHP content here
?>
<?php
$host_name = 'host';
$database = 'db';
$user_name = 'dbu';
$password = 'pass';

$link = new mysqli($host_name, $user_name, $password, $database);
$link->set_charset("utf8");

//A
$sql = "SELECT Identificador,respuestas_a,respuestas_b
        FROM preguntas 
        WHERE 
        opcion_a = '".$_GET['respuesta']."'
		LIMIT 1
		";
$result = $link->query($sql);
while($row = $result->fetch_assoc()) {
    $numero = $row["respuestas_a"];
    $id =  $row["Identificador"];
    $numero++;
    $sql2 = "UPDATE preguntas SET respuestas_a = ".$numero."
            WHERE Identificador = ".$id;
    $result2 = $link->query($sql2);
    $total = $numero + $row["respuestas_b"];
    echo "{\"a\":".(round(($numero/$total)*100)).",\"b\":".(round(($row["respuestas_b"]/$total)*100))."}";
}

//B
$sql = "SELECT Identificador,respuestas_a,respuestas_b
        FROM preguntas 
        WHERE 
        opcion_b = '".$_GET['respuesta']."'
		LIMIT 1
		";
$result = $link->query($sql);
while($row = $result->fetch_assoc()) {
    $numero = $row["respuestas_b"];
    $id =  $row["Identificador"];
    $numero++;
    $sql2 = "UPDATE preguntas SET respuestas_b = ".$numero."
            WHERE Identificador = ".$id;
    $result2 = $link->query($sql2);
    $total = $numero + $row["respuestas_a"];
    echo "{\"a\":".(round(($row["respuestas_a"]/$total)*100)).",\"b\":".(round(($numero/$total)*100))."}";
}

?>
