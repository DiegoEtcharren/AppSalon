<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Restablece tu Password escribiendo tu email</p>

<form class="formulario" method="POST" action="/crear-cuenta">
    <div class="campo">
        <label for="email">E-mail</label>
        <input 
            type="email" 
            id="email" 
            name="email"
            placeholder="Tu email"
        > 
    </div>
    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>
<div class="acciones">
    <a href="/">Ya tienes una cuenta? Inicia Sesion</a>
    <a href="/crear-cuenta">Aun no tienes una cuenta? Crear Cuenta</a>
</div>