<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__texto">Inicia sesión en DevWebCamp</p>

    <?php require_once __DIR__. '/../templates/alertas.php';?>

    <form class="formulario" method="POST" action="/login">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email:</label>
            <input
                type="email"
                class="formulario__input"
                placeholder="Tu email"
                name="email"
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

        <input type="submit" value="Iniciar sesión" class="formulario__submit">
    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__enlace">Crea una nueva cuenta</a>
        <a href="/olvide" class="acciones__enlace">Olvide mi contraseña</a>
    </div>
</main>