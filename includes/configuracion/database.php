<?php
function conectarDB() : mysqli{
    // $db = new mysqli('localhost', 'root', 'julian2003', 'bienesraices_crud');
    $db = mysqli_connect(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'));
    if (!$db){
        echo "No se pudo conectar con la base de datos";
        exit;
    }
    return $db;
}
?>