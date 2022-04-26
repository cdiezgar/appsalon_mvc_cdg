<div class="barra">
    <p>Hola: <?php echo $nombre ?? "" ?></p>

    <?php if (!$_SESSION["admin"] && str_contains($_SERVER["REQUEST_URI"], "/misCitas")): ?>
        <a href="/cita" class="boton">Nueva Cita</a>
    <?php endif; ?>

    <?php if (!$_SESSION["admin"] && !str_contains($_SERVER["REQUEST_URI"], "/misCitas")): ?>
        <a href="/misCitas" class="boton">Mis Citas</a>
    <?php endif; ?>

    <a href="/logout" class="boton">Cerrar Sesión</a>

</div>

<?php if ($_SESSION["admin"] ): ?>

<div class="barra-servicios">
    <a href="/admin" class="boton">Ver Citas</a>
    <a href="/servicios" class="boton">Ver Servicios</a>
    <a href="/servicios/crear" class="boton">Crear Servicio</a>

</div>

<?php endif; ?>