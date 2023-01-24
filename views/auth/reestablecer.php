<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__texto">Crea una nueva contraseña a DevWebCamp</p>

    <?php require_once __DIR__. '/../templates/alertas.php';?>

    <?php if($token_valido):?>
        <form class="formulario" method="POST">
            <div class="formulario__campo">
                <label for="password" class="formulario__label">Contraseña:</label>
                <input
                    type="password"
                    class="formulario__input"
                    placeholder="Tu contraseña"
                    name="password"
                    id="password">
            </div>

            <input type="submit" value="Restablecer contraseña" class="formulario__submit">
        </form>

        <div class="acciones">
            <a href="/registro" class="acciones__enlace">Crea una nueva cuenta</a>
            <a href="/login" class="acciones__enlace">Inicia sesión</a>
        </div>
    <?php endif;?>
</main>