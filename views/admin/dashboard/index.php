<h2 class="dashboard__heading"><?php echo $titulo;?></h2>

<main class="bloques">
    <div class="bloques__grid">
        <div class="bloque">
            <h3 class="bloque__heading">Ultimos registros</h3>

            <?php foreach($registros as $registro):?>
                <div class="bloque__contenido">
                    <p class="bloque__texto"><?php echo $registro->usuario->nombre . ' ' . $registro->usuario->apellido;?></p>
                </div>
            <?php endforeach;?>
        </div>

        <div class="bloque">
            <h3 class="bloque__heading">ingresos</h3>
            <p class="bloque__texto--total"><?php echo '$'.$total;?></p>
        </div>

        <div class="bloque">
            <h3 class="bloque__heading">Eventos con menos lugares disponibles.</h3>
            <?php foreach($menos_disponibles as $evento):?>
                <p class="bloque__texto"><?php echo $evento->nombre." - Disponibles: ".$evento->disponibles;?></p>
            <?php endforeach;?>
        </div>

        <div class="bloque">
            <h3 class="bloque__heading">Eventos con mas lugares disponibles.</h3>
            <?php foreach($mas_disponibles as $evento):?>
                <p class="bloque__texto"><?php echo $evento->nombre." - Disponibles: ".$evento->disponibles;?></p>
            <?php endforeach;?>
        </div>
    </div>
</main>