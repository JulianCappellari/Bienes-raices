<?php
function conectarDB() : mysqli{
    $db = new mysqli('localhost', 'root', 'julian2003', 'bienesraices_crud');
    if (!$db){
        echo "No se pudo conectar con la base de datos";
        exit;
    }
    return $db;
}
?>