<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__texto">Registrate en DevWebCamp</p>

    <?php require_once __DIR__. '/../templates/alertas.php';?>

    <form class="formulario" action="/registro" method="POST">
        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombre:</label>
            <input
                type="text"
                class="formulario__input"
                placeholder="Tu nombre(s)"
                name="nombre"
                value="<?php echo $usuario->nombre;?>"
                id="nombre">
        </div>
        <div class="formulario__campo">
            <label for="apellido" class="formulario__label">Apellidos:</label>
            <input
                type="text"
                class="formulario__input"
                placeholder="Tus apellidos"
                name="apellido"
                value="<?php echo $usuario->apellido;?>"
                id="apellido">
        </div>
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email:</label>
            <input
                type="email"
                class="formulario__input"
                placeholder="Tu email"
                name="email"
                value="<?php echo $usuario->email;?>"
                id="email">
        </div>
        <div class="formulario__campo">
            <label for="password" class="formulario__label">Contraseña:</label>
            <input
                type="password"
                class="formulario__input"
                placeholder="Tu contraseña"
                name="password"
                id="password">
        </div>
        <div class="formulario__campo">
            <label for="password2" class="formulario__label">Vuelve a repetir tu contraseña:</label>
            <input
                type="password"
                class="formulario__input"
                placeholder="Repite tu contraseña"
                name="password2"
                id="password2">
        </div>

        <input type="submit" value="Iniciar sesión" class="formulario__submit">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">Inicia sesión</a>
        <a href="/olvide" class="acciones__enlace">Olvide mi contraseña</a>
    </div>
</main>