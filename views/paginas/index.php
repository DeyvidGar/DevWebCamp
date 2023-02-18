<?php include_once __DIR__.'/conferencias.php';?>

<section class="resumen">
    <div class="resumen__grid">
        <div class="resumen__bloque" data-aos="fade-right">
            <p class="resumen__texto resumen__texto--numero"><?php echo $num_ponentes;?></p>
            <p class="resumen__texto">Speakers</p>
        </div>
        <div class="resumen__bloque" data-aos="fade-left">
            <p class="resumen__texto resumen__texto--numero"><?php echo $num_conferencias;?></p>
            <p class="resumen__texto">Conferencias</p>
        </div>
        <div class="resumen__bloque" data-aos="fade-right">
            <p class="resumen__texto resumen__texto--numero"><?php echo $num_workshops;?></p>
            <p class="resumen__texto">Workshops</p>
        </div>
        <div class="resumen__bloque" data-aos="fade-left">
            <p class="resumen__texto resumen__texto--numero">+500</p>
            <p class="resumen__texto">Asistentes</p>
        </div>
    </div>
</section>

<section class="speakers">
    <h2 class="speakers__heading">Speakers</h2>
    <p class="speakers__descripcion">Conoce a nuestros expertos que participan en DevWebCamp</p>

    <div class="speakers__grid">
        <?php foreach($ponentes as $ponente):?>
            <div class="speaker" <?php aos_animation();?>>
                <picture>
                    <source srcset="img/ponentes/<?php echo $ponente->imagen;?>.webp" type="image/webp">
                    <source srcset="img/ponentes/<?php echo $ponente->imagen;?>.avif" type="image/avif">
                    <img src="/img/ponentes/<<?php echo $ponente->image?>" alt="Image ponente" loading="lazy" width="200" height="300"
                    class="speaker__imagen">
                </picture>

                <div class="speaker__informacion">
                    <h4 class="speaker__nombre">
                        <?php echo $ponente->nombre ." ".$ponente->apellido;?>
                    </h4>
                    <p class="speaker__ubicacion">
                        <?php echo $ponente->ciudad ." ".$ponente->pais;?>
                    </p>
                    <nav class="speaker-social__sociales">
                        <?php $social = json_decode($ponente->redes);?>
                        <?php foreach($social as $key => $value):?>
                            <?php if($value):?>
                                <a class="speaker-social__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $value;?>">
                                    <span class="speaker-social__ocultar"><?php echo strtoupper($key);?></span>
                                </a>
                            <?php endif;?>
                        <?php endforeach;?>
                    </nav>
                    <ul class="speaker-skills__listado-tags">
                        <?php $tags = explode(',', $ponente->tags);?>
                        <?php foreach($tags as $tag):?>
                            <li class="speaker-skills__tags"><?php echo $tag;?></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</section>

<div class="mapa" id="mapa"></div>

<section class="boletos">
    <div class="boletos__heading">Boletos & precios</div>
    <div class="boletos__descripcion">Precio para DevWebCamp</div>

    <div class="boletos__grid">
        <div class="boleto boleto--presencial" <?php aos_animation();?>>
            <h4 class="boleto__logo">&#60;DevWebCamp/></h4>
            <p class="boleto__plan">Presencial</p>
            <p class="boleto__precio">$199</p>
        </div>
        <div class="boleto boleto--virtual" <?php aos_animation();?>>
            <h4 class="boleto__logo">&#60;DevWebCamp/></h4>
            <p class="boleto__plan">Virtual</p>
            <p class="boleto__precio">$99</p>
        </div>
        <div class="boleto boleto--gratis" <?php aos_animation();?>>
            <h4 class="boleto__logo">&#60;DevWebCamp/></h4>
            <p class="boleto__plan">Gratis</p>
            <p class="boleto__precio">$0</p>
        </div>
    </div>

    <div class="boleto__enlace-contenedor">
        <a href="/paquetes" class="boleto__enlace">Ver paquetes</a>
    </div>
</section>