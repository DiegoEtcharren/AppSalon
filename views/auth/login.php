<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Iniciar Sesion con tus datos</p>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input 
        name="email"
        id="email"
        placeholder="Tu email"
        type="email">
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input 
        name="password"
        id="password"
        placeholder="Tu Password"
        type="password">
    </div>
    <input type="submit" class="boton" value="Iniciar Sesion">
</form>
<div class="acciones">
    <a href="/crear-cuenta">Aun no tienes una cuenta? Crear Cuenta</a>
    <a href="/olvide">Olivde mi Password</a>
</div>