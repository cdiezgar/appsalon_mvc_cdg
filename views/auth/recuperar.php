<h1 class="nombre-pagina">Restablecer contraseña</h1>
<p class="descripcion-pagina">Introduce una nueva clave para tu usuario</p>

<?php
        include_once __DIR__ . "/../templates/alertas.php";
?>

<?php if ($error) return; ?>
<form class="formulario" method = "POST">

    <div class="campo">
        <label for="password">Email</label>
        <input 
            type="password"
            id="password"
            placeholder="Introduce tu password"
            name="password"
        />
    </div>

    <input type="submit" value = "Cambiar contraseña" class="boton">

</form>

<div class="acciones centrado">
    <a href="/">Iniciar Sesión</a>
</div>
