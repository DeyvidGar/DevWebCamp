<h2 class="dashboard__heading"><?php echo $titulo;?></h2>

<div class="dashboard__contenedor-boton">
    <a href="/admin/eventos" class="dashboard__boton">
        <i class="fa-solid fa-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario" id="formulario_crear_evento">
    <?php include_once __DIR__. '/../../templates/alertas.php';?>
    <form action="/admin/eventos/crear" method="POST" enctype="multipart/form-data" class="formulario">

    <?php include_once __DIR__. '/formulario.php';?>

    <input type="submit" value="Crear ponente" class="formulario__submit formulario__submit--registrar">
    </form>
</div>