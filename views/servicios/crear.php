<h1 class='nombre-pagina'>Nuevo Servicio</h1>
<p class='descripcion-pagina'>Llena todos los campos</p>

<?php 
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>
 
<form action="/servicios/crear" method="POST" class='formulario'>
    <?php 
        include_once __DIR__ . '/../servicios/formulario.php';
    ?>

    <input type='submit' class='boton' value='Agregar Servicio'>
</form>