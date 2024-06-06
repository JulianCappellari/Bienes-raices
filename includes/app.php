<?php
require 'funciones.php';
require 'configuracion/database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectar a la BD
$db = conectarDB();

use Model\ActiveRecord;


ActiveRecord::setDB($db);

?>