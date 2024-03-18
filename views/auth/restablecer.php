<div class="contenedor restablecer">
<?php include_once __DIR__ . '/../templates/nombre-sitio.php';?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu Password</p>
        <form class="formulario" action="/restablecer" method="post">

            <div class="campo">
                <label for="password">Password</label>
                <input 
                type="password"
                id="password"
                placeholder="Tu Password"
                name="password"
                >
            </div>
            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>
        <div class="acciones">
            <a href="/crear">¿Aun no tienes una cuenta?</a>
            <a href="/olvide">¿Olvidaste tu contraseña?</a>
        </div>
    </div><!--.contenedor-sm -->
</div>