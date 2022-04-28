<?php include_once __DIR__ . "/../templates/barra.php"; ?>

<h1 class="nombre-pagina">Panel de Administración</h1>
<h2 class="nombre-pagina">Buscar Citas</h1>

<?php include_once __DIR__ . "/../templates/buscadorCitas.php"; ?>

<?php if(count($citas) === 0) : ?>
    <p class="sin-citas">No existen citas para el día indicado</p>
<?php endif; ?>

<div id="citas-admin">
    <?php $idCita = 0;?>
    <ul class="citas">
        <?php foreach($citas as $key => $cita): ?>
            <?php if($idCita != $cita->id): $total = 0;?>

                <li>
                    <p>ID: <span> <?php echo $cita->id; ?> </span> </p>
                    <p>Hora: <span> <?php echo $cita->hora; ?> </span> </p>
                    <p>Cliente: <span> <?php echo $cita->cliente; ?> </span> </p>
                    <p>Email: <span> <?php echo $cita->email; ?> </span> </p>
                    <p>Telefono: <span> <?php echo $cita->telefono; ?> </span> </p>
                    <h3>Servicios</h3>
                <?php $idCita = $cita->id?>
            <?php endif;?>
                    <p class="servicio"><?php echo $cita->servicio . ": $" .$cita->precio ?></p>
                <?php
                $actual=$cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;
                $total += $cita->precio;
                    if(esUltimo($actual,$proximo)) :?>
                        <p class="total">Total: <span>$<?php echo $total; ?></span></p>
                    
                        <form action="/cita/eliminar" method = "POST">

                        <input type="hidden" name="id" value="<?php echo $cita->id;?>">
                        <input type="submit" class="boton anular-cita" value="Eliminar">

                        </form>
                    
                        <?php endif?>
        <?php endforeach;?>
    </ul>
</div>

<?php
    $script = "<script src='build/js/buscador.js'></script>";
?>


