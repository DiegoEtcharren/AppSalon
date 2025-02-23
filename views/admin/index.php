<h1 class="nombre-pagina">Panel de Administracion</h1>
<?php
include_once __DIR__ . '/../templates/barra.php';
?>

<h2>Buscar Citas</h2>
<div class='busqueda'>
    <form class='formulario'>
        <div class='campo'>
            <label for='fecha'>Fecha</label>
            <input
                type='date'
                id='fecha'
                name='fecha'>
        </div>
    </form>
</div>

<div id='citas-admin'>
    <ul class='citas'>
        <?php
        $idCita = null;
        foreach ($citas as $cita):
        ?>
            <?php if ($idCita !== $cita->id): ?>
                <li>
                    <p>ID: <span><?php echo $cita->id ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora ?></span></p>
                    <p>Nombre: <span><?php echo $cita->cliente ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono ?></span></p>
                    <p>Email: <span><?php echo $cita->email ?></span></p>
                    <h3>Servicios</h3>
                </li>
                <?php $idCita = $cita->id; ?>
            <?php endif; ?>
            <p class='servicio'><?php echo "{$cita->nombre}  $ {$cita->precio}" ?></p>
        <?php endforeach; ?>
    </ul>
</div>