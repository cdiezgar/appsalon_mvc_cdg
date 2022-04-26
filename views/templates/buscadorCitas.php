<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input 
                class="fecha-input"
                type="date"
                id="fecha"
                name="fecha"
                value="<?php echo $fecha?>"
            />
        </div>
    </form>
</div>

<?php include_once __DIR__ . "/alertas.php"; ?>

<div class="paginacion">
        <button id="dia-anterior" class="boton">
            &laquo; Día Anterior
        </button>

        <button id="dia-hoy" class="boton">
             Hoy
        </button>

        <button id="dia-siguiente" class="boton">
            &raquo; Día Siguiente
        </button>
    </div>

