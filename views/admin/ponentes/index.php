<h2 class="dashboard__heading"><?php echo $titulo;?></h2>

<div class="dashboard__contenedor-boton">
    <a href="/admin/ponentes/crear" class="dashboard__boton">
        <i class="fa-solid fa-user-plus"></i>
        Añadir ponente
    </a>
</div>
<?php require_once __DIR__. '/../../templates/alertas.php';?>
<div class="dashboard__contenedor">
    <?php if(!empty($ponentes)):?>
        <table class="table">
            <thead class="table__thead">
                <tr class="table__tr">
                    <th class="table__th" scope="col">Nombre</th>
                    <th class="table__th" scope="col">Ubicacion</th>
                    <th class="table__th" scope="col"></th>
                </tr>
            </thead>
            <tbod class="table__tbody">
                <?php foreach($ponentes as $ponente):?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $ponente->nombre. " " . $ponente->apellido;?>
                        </td>
                        <td class="table__td">
                            <?php echo $ponente->ciudad. ", " . $ponente->pais;?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/ponentes/editar?id=<?php echo $ponente->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar info.
                            </a>
                            <form class="table__formualario" action="/admin/ponentes/eliminar" method="POST">
                                <input type="hidden" name="id" value="<?php echo $ponente->id;?>">
                                <button class="table__accion table__accion--eliminar" type="submit">
                                    <i class="fa-solid fa-user-minus"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbod>
        </table>
    <?php else:?>
        <p class="text-center">No hay ponentes registrados.</p>
    <?php endif;?>
</div>

<?php echo $paginacion;?>