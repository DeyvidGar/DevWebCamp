<h2 class="dashboard__heading"><?php echo $titulo;?></h2>

<div class="dashboard__contenedor-boton">
    <a href="/admin/eventos/crear" class="dashboard__boton">
        <i class="fa-solid fa-user-plus"></i>
        Añadir evento
    </a>
</div>
<?php require_once __DIR__. '/../../templates/alertas.php';?>