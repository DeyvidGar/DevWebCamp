<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información personal</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre:</label>
        <input
            type="text"
            class="formulario__input"
            placeholder="Nombre del ponente"
            name="nombre"
            value="<?php echo $ponente->nombre ?? '';?>"
            id="nombre">
    </div>
    <div class="formulario__campo">
        <label for="apellido" class="formulario__label">Apellido:</label>
        <input
            type="text"
            class="formulario__input"
            placeholder="Apellido del ponente"
            name="apellido"
            value="<?php echo $ponente->apellido ?? '';?>"
            id="apellido">
    </div>
    <div class="formulario__campo">
        <label for="ciudad" class="formulario__label">Ciudad:</label>
        <input
            type="text"
            class="formulario__input"
            placeholder="Ciudad procedencia"
            name="ciudad"
            value="<?php echo $ponente->ciudad ?? '';?>"
            id="ciudad">
    </div>
    <div class="formulario__campo">
        <label for="pais" class="formulario__label">Pais:</label>
        <input
            type="text"
            class="formulario__input"
            placeholder="Pais ponente"
            name="pais"
            value="<?php echo $ponente->pais ?? '';?>"
            id="pais">
    </div>
    <div class="formulario__campo">
        <label for="imagen" class="formulario__label">Imagen:</label>
        <input
            type="file"
            class="formulario__input formulario__input--file"
            name="imagen"
            id="imagen">
    </div>
    <?php if(isset($ponente->imagen_actual)):?>
        <p class="formulario__texto">Imagen actual:</p>
        <div class="formulario__imagen">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'].'/img/ponentes/'. $ponente->imagen;?>.webp" type="image/webp" alt="Imagen ponente">
                <source srcset="<?php echo $_ENV['HOST'].'/img/ponentes/'. $ponente->imagen;?>.png" type="image/png" alt="Imagen ponente">
                <img src="<?php echo $_ENV['HOST'].'/img/ponentes/'. $ponente->imagen;?>.png" alt="Imagen ponente">
            </picture>
        </div>
    <?php endif;?>
</fieldset>
<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información extra</legend>

    <div class="formulario__campo">
        <label for="pais" class="formulario__label">Areas de experiencia(separar por comas):</label>
        <input
            type="text"
            class="formulario__input"
            placeholder="Ej. Node, JS, PHP, CSS, UX / UI"
            id="tags_input">
        <div id="tags" class="formulario__listado"></div>
        <input type="hidden" name="tags" value="<?php echo $ponente->tags ?? '';?>">
    </div>
</fieldset>
<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Redes sociales</legend>

    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-square-facebook"></i>
            </div>
            <input
                type="text"
                class="formulario__input--sociales"
                placeholder="Facebook"
                name="redes[facebook]"
                value="<?php echo $redes->facebook ?? '';?>">
        </div>
    </div>
    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-square-twitter"></i>
            </div>
            <input
                type="text"
                class="formulario__input--sociales"
                placeholder="Twitter"
                name="redes[twitter]"
                value="<?php echo $redes->twitter ?? '';?>">
        </div>
    </div>
    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-square-youtube"></i>
            </div>
            <input
                type="text"
                class="formulario__input--sociales"
                placeholder="YouTube"
                name="redes[youtube]"
                value="<?php echo $redes->youtube ?? '';?>">
        </div>
    </div>
    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-square-instagram"></i>
            </div>
            <input
                type="text"
                class="formulario__input--sociales"
                placeholder="Instagram"
                name="redes[instagram]"
                value="<?php echo $redes->instagram ?? '';?>">
        </div>
    </div>
    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-tiktok"></i>
            </div>
            <input
                type="text"
                class="formulario__input--sociales"
                placeholder="TikTok"
                name="redes[tiktok]"
                value="<?php echo $redes->tiktok ?? '';?>">
        </div>
    </div>
    <div class="formulario__campo">
        <div class="formulario__contenedor-icono">
            <div class="formulario__icono">
                <i class="fa-brands fa-square-github"></i>
            </div>
            <input
                type="text"
                class="formulario__input--sociales"
                placeholder="GitHub"
                name="redes[github]"
                value="<?php echo $redes->github ?? '';?>">
        </div>
    </div>
</fieldset>