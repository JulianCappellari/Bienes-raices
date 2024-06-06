<?php

namespace Controllers;

use MVC\Router;
use Model\Vendedor;

class VendedorControllers{
    public static function index(Router $router) { //*
        $vendedores = Vendedor::all();

        // Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('vendedores/admin', [
            'vendedores' => $vendedores,
            'resultado' => $resultado
        ]);
    }
    public static function crear(Router $router){
        $errores = Vendedor::getErrores();

        $vendedor = new Vendedor;
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Crea una nueva instancia 
            $vendedor = new Vendedor($_POST['vendedor']);
    
            $errores = $vendedor->validar();
    
            if(empty($errores)){
                $resultado = $vendedor->guardar();
                if($resultado){
                    header('Location: /admin');
                }
            }
        }
        $router->render('vendedores/crear', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }

    public static function actualizar(Router $router){
        
        $id = validarORedireccionar('/admin');

        // Obetner los datos del vendedor a actualizar 
        $vendedor = Vendedor::find($id);

        $errores = Vendedor::getErrores();
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Asignar los valores
            $arreglo = $_POST['vendedor'];
    
            $vendedor->sincronizar($arreglo);
    
            // Validacion
            $errores = $vendedor->validar();
    
            if(empty($errores)){
                $resultado = $vendedor->guardar();
                if($resultado) {
                    header('location: /admin');
                }
            }
            
        }
        $router->render('vendedores/actualizar', [
            'errores' => $errores,
            'vendedor' => $vendedor
        ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if($id){

                $tipo = $_POST['tipo'];
                if(validarTipoContenido($tipo)){
                    if($tipo === 'vendedor'){
                        $vendedor = Vendedor::find($id);
                        $vendedor->eliminar();
                    }
                }
            }
        }
    }
}