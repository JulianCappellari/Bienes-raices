<?php 
namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as image;

class PropiedadControllers{
    public  static function index(Router $router) {

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();

        $resultado = $_GET['resultado'] ?? null; // Busca y si no existe el valor lo pone como null
        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }
    public static function crear(Router $router) {
        // Arreglo con mensajes de errore
        $errores = Propiedad::getErrores();
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Crea una nueva instancia 
            $propiedad = new Propiedad($_POST['propiedad']);
    
            // Generar un nombre unico para cada imagen
            $nombreImagen = md5(uniqid(rand(), true )) . ".jpg"; // Genera numero aleatorias
    
            //Setear la imagen
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad -> setImagen($nombreImagen);
            }
            
            $errores = $propiedad->validar();
    
            //insetar a la base de datos
            if(empty($errores)){
                // Crear la carpeta para subir imagenes
                if(!is_dir(CARPETA_IMAGENES)){
                    mkdir(CARPETA_IMAGENES);
                }
    
                // Subir la imagen a la carpeta
                //move_uploaded_file($imagen['tmp_name'], $carpetaImagnes  . $nombreImagen  );
    
                //Guarda la imagen en el servidor
                $image ->save(CARPETA_IMAGENES . $nombreImagen);
    
                $resultado = $propiedad->guardar();
                if($resultado) {
                    header('location: /admin');
                }
            }
        };

        $router->render('propiedades/crear',[
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }
    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');  //admin+
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();

        $errores = Propiedad::getErrores();
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){

            // Asignar los atributos
            $arreglo = $_POST['propiedad'];
        
            $propiedad->sincronizar($arreglo);
    
            $errores = $propiedad->validar();
    
    
            $nombreImagen = md5(uniqid(rand(), true )) . ".jpg";
            //Subida de archivos
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
                $propiedad -> setImagen($nombreImagen);
            }
            
            //insetar a la base de datos
            if(empty($errores)){
                //Almacenar la imagen
                if($_FILES['propiedad']['tmp_name']['imagen']){
                    $image ->save(CARPETA_IMAGENES . $nombreImagen);
                }
                //Guardar los datos de la propiedad
                $resultado = $propiedad->guardar();
                if($resultado) {
                    header('location: /admin');
                }
            }
        };

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }
    public static function eliminar(){
        // Para eliminar 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $tipo = $_POST['tipo'];
            // peticiones validas
            if(validarTipoContenido($tipo) ) {
                // Leer el id
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);
    
                // encontrar y eliminar la propiedad
                $propiedad = Propiedad::find($id);
                $resultado = $propiedad->eliminar();

                // Redireccionar
                if($resultado) {
                    header('location: /admin');
                }
            }
        }
    }
}