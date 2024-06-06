<?php


define('TEMPLTES_URL', __DIR__ .'/templates');
define('FUNCIONES_URL',__DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate( string $nombre, bool $inicio = false ){
    include TEMPLTES_URL . "/${nombre}.php";
}
function estaAutenticado() {
    session_start();
    
    if(!$_SESSION['login']){
        header ('location: /index.php');
    }
   
}

function debugear($variable){
    echo "<prev>";
    var_dump($variable);
    echo "</prev>";
    exit;
}
function s($html) : string{
    $s = htmlspecialchars($html);
    return $s;
}


//Validar algun tipo de contenido
function validarTipoContenido($tipo){
    $tipos = ['vendedor' , 'propiedad'];

    return in_array($tipo, $tipos);
}

// Muestra los mensajes
function mostrarMensajes($codigo){
    $mensaje = '';
    switch($codigo){
        case 1:
            $mensaje = 'Creado Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;


}

function validarORedireccionar(string $url){
    // Validacion en la url
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id){
        header("Location: ${url}"); //Redireige
    }
    return $id;
}

?>
