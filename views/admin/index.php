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
                name='fecha'
                value='<?php echo $fecha ?>'>
        </div>
    </form>
</div>

<?php 
    if(empty($citas)): ?>
        <h2>No Hay Citas en esta Fecha</h2>
    <?php endif; ?>
<div id='citas-admin'>
    <ul class='citas'>
        <?php
        $idCita = null;
        foreach ($citas as $key => $cita):
            if ($idCita !== $cita->id):
                $total = 0; ?>
                <li>
                    <p>ID Cita: <span><?php echo $cita->id ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora ?></span></p>
                    <p>Nombre: <span><?php echo $cita->cliente ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono ?></span></p>
                    <p>Email: <span><?php echo $cita->email ?></span></p>
                    <h3>Servicios</h3>
                    <?php $idCita = $cita->id; ?>
                </li>
                <?php endif; ?>
                <p class='servicio'><?php echo "{$cita->nombre}  $ {$cita->precio}" ?></p>
                <?php
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;
                $total += $cita->precio;
                if (esUltimo($actual, $proximo)): ?>
                    <p class='total'>Total: <span>$<?php echo $total ?></span></p>
                <?php endif; ?>
                
            <?php endforeach; ?>
    </ul>
</div>

<?php 
    $script = "<script src='build/js/buscador.js'></script>";
?>