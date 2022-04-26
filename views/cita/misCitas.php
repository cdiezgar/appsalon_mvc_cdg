<?php include_once __DIR__ . "/../templates/barra.php"; ?>

<h1 class="nombre-pagina">Tus Citas</h1>

<?php if(count($citas) === 0) : ?>
    <p class="sin-citas">No existen citas pendientes</p>
<?php endif; ?>

<div id="misCitas">
    <?php $idCita = 0;?>
    <ul class="citas">
        <?php foreach($citas as $key => $cita): ?>
            <?php if($idCita != $cita->id): $total = 0;?>
                <li id="mi-cita">
                    <input type="hidden" value = "<?php echo $cita->id ?>">
                    <p>Cita: <span class="mi-cita"> <?php echo $cita->cita; ?> </span> </p>
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
                        <button class="boton anular-cita">Anular Cita</button>
                    <?php endif?>
                
        <?php endforeach;?>
    </ul>
</div>

<?php $script = "

    <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='build/js/misCitas.js'></script>

    ";

?>