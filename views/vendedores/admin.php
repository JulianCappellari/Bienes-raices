
<main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>
        <?php 
            $mensaje = mostrarMensajes(intval($resultado));
                if($mensaje) { ?>
                    <p class="alerta exito"><?php echo s($mensaje) ?> </p>
                <?php }   
            
    ?>

    <a href="propiedades/crear" class="boton boton-verde">Nueva Propiedad</a>
    <a href="vendedores/crear" class="boton boton-amarillo">Nuevo Vendedor</a>


</main>