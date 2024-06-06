<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasControllers{
    public static function index(Router $router){
        $propiedades = Propiedad::get(3);
        
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => true
        ]);
    }
    public static function nosotros(Router $router){
        $router->render('paginas/nosotros'); // Cuando es estatica no lleva corchetes
    }
    public static function propiedades(Router $router){
        $propiedades = Propiedad::all();
        $router->render('paginas/propiedades',[
            'propiedades' => $propiedades
        ]);
    }
    public static function propiedad(Router $router){
        $id = validarORedireccionar('/propiedades');

        //Buscar la propiedad por su id
        $propiedad = Propiedad::find($id);
        $router->render('paginas/propiedad',[
            'propiedad' => $propiedad
        ]);
    }
    public static function blog(Router $router){
        $router->render('paginas/blog');
    }
    public static function entrada(Router $router){
        $router->render('paginas/entrada');
    }
    public static function contacto(Router $router){
        $mensaje = null;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $respuestas = $_POST['contacto'];
            // Crear una instancia de phpmailer
            $mail = new PHPMailer();

            //Configurar SMTP 
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '14353e83759534';
            $mail->Password= 'c253542e0e77fd';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            // Configurar el contenido del mail
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@bienesraices.com' , 'BienesRaices.com'); // quien lo envia ; quien lo recibe
            $mail->Subject = 'Tiene un nuevo mensaje';

            // Habilitar el HTML
            $mail->isHTML(true); // habilita el html
            $mail->CharSet = 'UTF-8';

            // Definimos el contenido
            $contenido = '<html>' ;
            $contenido  .= '<p> Tienes un nuevo mensaje </p>';
            $contenido  .= '<p> Nombre: ' .  $respuestas['nombre'] . '</p>';
            

            // Enviar de forma condiccional algunos campos de email o telefono
            if($respuestas['contacto'] === 'telefono'){
                $contenido  .= '<p> Prefiere ser contactado como: ' .  $respuestas['contacto'] . '</p>';
                $contenido  .= '<p> Telefono: ' .  $respuestas['telefono'] . '</p>';
                $contenido  .= '<p> Fecha de contacto: ' .  $respuestas['fecha'] . '</p>';
                $contenido  .= '<p> Hora:' .  $respuestas['hora'] . '</p>';
            }else{
                $contenido  .= '<p> Prefiere ser contactado como: ' .  $respuestas['contacto'] . '</p>';
                $contenido  .= '<p> Email: ' .  $respuestas['email'] . '</p>';
            }

            $contenido  .= '<p> Mensaje: ' .  $respuestas['mensaje'] . '</p>';
            $contenido  .= '<p> Vende o compra: ' .  $respuestas['tipo'] . '</p>';
            $contenido  .= '<p>Precio o presupuesto: $' .  $respuestas['precio'] . '</p>';
            
            $contenido .= '</html>';


            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin HTML';

            // Enviar el mail
            if($mail->send()){
                $mensaje =  "Mensaje Enviado Correctamente";
            }else{
                $mensaje = "el mensaje no se pudo enviar";
            }
        }


        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}