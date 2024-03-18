<div class="contenedor olvide">
<?php include_once __DIR__ . '/../templates/nombre-sitio.php';?>
    <div class="contenedor-sm">
    <div class="contenedor crear">
<?php include_once __DIR__ . '/../templates/nombre-sitio.php';?>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu cuenta en UpTask
        </p>
        <form class="formulario" action="/olvide" method="post">

        <div class="campo">
                <label for="email">Email</label>
                <input 
                type="email"
                id="email"
                placeholder="Tu Email"
                name="email"
                >
        </div>


            <input type="submit" class="boton" value="Recuperar Cuenta">
        </form>
        <div class="acciones">
            <a href="/">Iniciar Sesión</a>
            <a href="/crear">¿Aun no tienes una cuenta?</a>
        </div>
    </div><!--.contenedor-sm -->
</div>