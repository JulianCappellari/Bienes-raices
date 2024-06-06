<?php
    //var_dump($_SESSION);
    
    if(!isset($_SESSION)){
        session_start();
    }
    $auth = $_SESSION['login'] ?? false;
    //var_dump($auth);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    
    <header class="header <?php echo $inicio ? 'inicio' : ''?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="../../build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="../../build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="../../build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="/nosotros.php">Nosotros</a>
                        <a href="/anuncios.php">Anuncios</a>
                        <a href="/blog.php">Blog</a>
                        <a href="/contacto.php">Contacto</a>
                        <?php if (!$auth) : ?>
                            <a href="login.php">Iniciar Sesion</a>
                        <?php endif; ?>
                        <?php if ($auth): ?>
                            <a href="/cerrar_sesion.php">Cerrar Sesion</a>
                        <?php endif; ?>
                        <?php if($auth): ?>
                            <a href="/admin/index.php">Administrar</a>
                        <?php endif; ?>
                        
                    </nav>
                </div>
   
                
            </div> <!--.barra-->

            <?php if($inicio) { 
                echo "<h1>Venta de Casas y Departamentos  Exclusivos de Lujo</h1>";
             } ?>
        </div>
    </header>