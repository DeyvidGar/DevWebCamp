<h2 class="dashboard__heading"><?php echo $titulo;?></h2>

<div class="dashboard__contenedor-boton">
    <a href="/admin/ponentes" class="dashboard__boton">
        <i class="fa-solid fa-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario" id="formulario_crear_ponente">

    <?php include_once __DIR__. '/../../templates/alertas.php';?>

    <form method="POST" enctype="multipart/form-data" class="formulario">

        <?php include_once __DIR__. '/formulario.php';?>

        <input type="submit" value="Actualizar ponente" class="formulario__submit formulario__submit--registrar">

    </form>

</div>