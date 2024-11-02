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
// SQL query to fetch a random question
  $sql = "SELECT pregunta, opcion_a, opcion_b FROM preguntas ORDER BY RAND() LIMIT 1";
  $result = $link->query($sql);

  // Check if the query returned a result
  if ($result->num_rows > 0) {
    // Fetch the row
    $row = $result->fetch_assoc();

    // Prepare the JSON output
    $output = [
        "pregunta" => $row['pregunta'],
        "opciones" => [
            "A" => $row['opcion_a'],
            "B" => $row['opcion_b']
        ]
    ];

    // Set header to application/json for proper handling on client side
    header('Content-Type: application/json');
    // Encode the array to JSON and output it
    echo json_encode($output);

  } else {
    echo json_encode(array("error" => "No questions found"));
  }

  // Close the database connection
  $link->close();
  
?>
