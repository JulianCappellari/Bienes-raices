<main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesion</h1>

        <?php
        foreach($errores as $error):
        ?>
            <div class="alerta error">
                <?php echo $error ;
                ?>
            </div>
        <?php endforeach; ?>


        <form method="POST" class="formulario" action="/login">
        <fieldset>
                <legend>Email y password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="email" require>

                <label for="password">Constaseña</label>
                <input type="password" name="password" placeholder="Tu password" id="password" require>

            </fieldset>
            <input type="submit" value="Iniciar sesion" class="boton boton-verde">

        </form>

    </main>