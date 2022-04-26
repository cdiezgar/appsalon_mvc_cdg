<h1 class = "nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Rellena el siguiente formulario para crear una cuenta</p>

<form action="/crear-cuenta" class="formulario" method = "POST">

    <?php
        include_once __DIR__ . "/../templates/alertas.php";
    ?>

    <div class="campo">
        <label for="nombre">Nombre</label>
        <input 
            type="text"
            id="nombre"
            placeholder="Introduce tu nombre"
            name="nombre"
            value = "<?php echo s($usuario->nombre) ?>"
        />
    </div>
    <div class="campo">
        <label for="apellido1">Primer Apellido</label>
        <input 
            type="text"
            id="apellido1"
            placeholder="Introduce tu apellido"
            name="apellido1"
            value = "<?php echo s($usuario->apellido1) ?>"

        />
    </div>
    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input 
            type="tel"
            id="telefono"
            placeholder="Introduce tu número de teléfono"
            name="telefono"
            value = "<?php echo s($usuario->telefono) ?>"
        />
    </div>
    <div class="campo">
        <label for="email">E-mail</label>
        <input 
            type="email"
            id="email"
            placeholder="Introduce tu dirección de correo electrónico"
            name="email"
            value = "<?php echo s($usuario->email) ?>"
        />
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            id="password"
            placeholder="Introduce tu password"
            name="password"
        />
    </div>

    <input type="submit" value = "Crear Cuenta" class = "boton">


</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? ¡Inicia sesión!</a>
    <a href="/olvide">¿Olvidáste tu password?</a>
</div>
