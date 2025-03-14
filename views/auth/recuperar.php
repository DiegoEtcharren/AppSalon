<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nueva password a continuacion</p>
<?php 
    include_once __DIR__ . '/../templates/alertas.php'
?>
<?php if(!$error) : ?>
    <form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password" 
            id="password" 
            name="password"
            placeholder="Tu Nuevo Password"
        > 
    </div>
    <input type="submit" class="boton" value="Guardar Nuevo Password">
</form>
<?php endif; ?>
<div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia Sesion</a>
    <a href="/crear-cuenta">Aun no tienes una cuenta? Crear Cuenta</a>
</div>