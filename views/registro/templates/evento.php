<div class="evento swiper-slide">
    <p class="evento__hora"><?php echo $evento->hora->hora;?></p>

    <div class="evento__informacion">
        <h3 class="evento__nombre"><?php echo $evento->nombre;?></h3>

        <p class="evento__contenido"><?php echo $evento->descripcion;?></p>

        <div class="evento__autor-info">
            <picture>
                <source srcset="<?php echo $_ENV['HOST']; //en caso de no visualizar las imagenes hacemos uso de las variables de entorno?>/img/ponentes/<?php echo $evento->ponente->imagen;?>.webp" type="image/webp" alt="Imagen ponente">
                <source srcset="<?php echo $_ENV['HOST']; //en caso de no visualizar las imagenes hacemos uso de las variables de entorno?>/img/ponentes/<?php echo $evento->ponente->imagen;?>.png" type="image/png" alt="Imagen ponente">
                <img
                    src="<?php echo $_ENV['HOST']; //en caso de no visualizar las imagenes hacemos uso de las variables de entorno?>/img/ponentes/<?php echo $evento->ponente->imagen;?>.png"
                    class="evento__autor-imagen"
                    loading="lazy"
                    width="200"
                    height="300"
                    alt="Imagen ponente">
            </picture>

            <p class="evento__autor-nombre"><?php echo $evento->ponente->nombre." ".$evento->ponente->apellido;?></p>
        </div>

        <button
        type="button"
        data-id="<?php echo $evento->id;?>"
        <?php echo ($evento->disponibles == 0) ? 'disabled' : '';?>
        class="evento__agregar"
        ><?php echo ($evento->disponibles == 0) ? 'Agotado (disponibles: ' : 'Agregar (disponibles: ';?>
        <?php echo $evento->disponibles;?>)</button>
    </div>
</div>