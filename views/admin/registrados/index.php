<h2 class="dashboard__heading"><?php echo $titulo;?></h2>
<?php require_once __DIR__. '/../../templates/alertas.php';?>
<div class="dashboard__contenedor">
    <?php if(!empty($registros)):?>
        <table class="table">
            <thead class="table__thead">
                <tr class="table__tr">
                    <th class="table__th" scope="col">Nombre</th>
                    <th class="table__th" scope="col">Email</th>
                    <th class="table__th" scope="col">Plan</th>
                </tr>
            </thead>
            <tbod class="table__tbody">
                <?php foreach($registros as $registro):?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $registro->usuario->nombre. " " . $registro->usuario->apellido;?>
                        </td>
                        <td class="table__td">
                            <?php echo $registro->usuario->email;?>
                        </td>
                        <td class="table__td">
                            <?php echo $registro->paquete->nombre;?>
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