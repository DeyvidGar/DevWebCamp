<h2 class="dashboard__heading"><?php echo $titulo;?></h2>

<div class="dashboard__contenedor-boton">
    <a href="/admin/eventos/crear" class="dashboard__boton">
        <i class="fa-solid fa-user-plus"></i>
        Añadir evento
    </a>
</div>
<?php require_once __DIR__. '/../../templates/alertas.php';?>
<div class="dashboard__contenedor">
    <?php if(!empty($eventos)):?>
        <table class="table">
            <thead class="table__thead">
                <tr class="table__tr">
                    <th class="table__th" scope="col">Evento</th>
                    <th class="table__th" scope="col">Tipo</th>
                    <th class="table__th" scope="col">Dia y Hora</th>
                    <th class="table__th" scope="col">Ponente</th>
                    <th class="table__th" scope="col"></th>
                </tr>
            </thead>
            <tbod class="table__tbody">
                <?php foreach($eventos as $evento):?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $evento->nombre;?>
                        </td>
                        <td class="table__td">
                            <?php echo $evento->categoria_id->nombre;?>
                        </td>
                        </td>
                        <td class="table__td">
                            <?php echo $evento->dia_id->nombre.', '.$evento->hora_id->hora;?>
                        </td>
                        <td class="table__td">
                            <?php echo $evento->ponente_id->nombre.' '.$evento->ponente_id->apellido;?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/eventos/editar?id=<?php echo $evento->id;?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar info.
                            </a>
                            <form class="table__formualario" action="/admin/eventos/eliminar" method="POST">
                                <input type="hidden" name="id" value="<?php echo $evento->id;?>">
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