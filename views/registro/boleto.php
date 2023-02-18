<main class="boletos">
    <h2 class="boletos__heading"><?php echo $titulo;?></h2>
    <p class="boletos__descripcion">Tu boleto - puedes compartirlo en redes sociales.</p>

    <div class="boletos__grid">
        <div class="boleto boleto--<?php echo strtolower($registro->paquete->nombre);?> boleto--acceso">
            <h4 class="boleto__logo">&#60;DevWebCamp/></h4>
            <p class="boleto__plan"><?php echo $registro->paquete->nombre?></p>
            <p class="boleto__nombre"><?php echo $registro->usuario->nombre.' '.$registro->usuario->apellido;?></p>
            <p class="boleto__codigo">#<?php echo $registro->token?></p>
        </div>
    </div>
</main>