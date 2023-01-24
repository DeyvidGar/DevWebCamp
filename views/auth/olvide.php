<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__texto">Recupera tu acceso a DevWebCamp</p>

    <?php require_once __DIR__. '/../templates/alertas.php';?>

    <form class="formulario" method="POST" action="/olvide">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email:</label>
            <input
                type="email"
                class="formulario__input"
                placeholder="Tu email"
                name="email"
                id="email">
        </div>

        <input type="submit" value="Recibir instrucciones" class="formulario__submit">
    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__enlace">Crea una nueva cuenta</a>
        <a href="/login" class="acciones__enlace">Inicia sesión</a>
    </div>
</main>