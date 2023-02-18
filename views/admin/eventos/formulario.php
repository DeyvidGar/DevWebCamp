<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información evento</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre evento:</label>
        <input
            type="text"
            class="formulario__input"
            placeholder="Nombre eventos"
            name="nombre"
            value="<?php echo $evento->nombre ?? '';?>"
            id="nombre">
    </div>
    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripción:</label>
        <textarea
            class="formulario__input"
            name="descripcion"
            rows="5"
            id="descripcion"><?php echo $evento->descripcion ?? '';?></textarea>
    </div>
    <div class="formulario__campo">
        <label for="categoria" class="formulario__label">Categoria:</label>
        <select name="categoria_id" class="formulario__select" id="categoria">
            <option selected disabled value="">- Seleccionar -</option>
            <?php foreach($categorias as $categoria):?>
                <option
                <?php echo ($evento->categoria_id === $categoria->id) ? 'selected' : '';?>
                value="<?php echo $categoria->id;?>"><?php echo $categoria->nombre;?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="formulario__campo">
        <label class="formulario__label">Dia:</label>
        <div class="formulario__radio">
            <?php foreach ($dias as $dia):?>
                <div>
                    <label for="<?php echo strtolower($dia->nombre);?>"><?php echo strtoupper($dia->nombre);?></label>
                    <input
                        type="radio"
                        name="dia_id"
                        <?php echo $evento->dia_id === $dia->id ? 'checked' : ''; ?>
                        id="<?php echo strtolower($dia->nombre);?>"
                        value="<?php echo $dia->id;?>">
                </div>
            <?php endforeach;?>
        </div>

        <input type="hidden" name="dia_id" id="dia_id" value="<?php echo $evento->dia_id ?? '';?>"> <!-- este input es que se envia ala base de datos -->
    </div>
    <div class="formualrio__campo">
        <label for="" class="formulario__label">Selecciona la hora:</label>
        <ul class="horas" id="horas">
            <?php foreach($horas as $hora):?>
                <li data-hora-id="<?php echo $hora->id;?>" class="horas__hora horas__hora--desabilitado"><?php echo $hora->hora;?></li>
            <?php endforeach;?>
        </ul>
    </div>

    <input type="hidden" name="hora_id" value="<?php echo $evento->hora_id ?? '';?>"> <!-- este input es que se envia ala base de datos -->
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información extra</legend>
    <div class="formulario__campo">
        <label for="ponente" class="formulario__label">Nombre del ponente:</label>
        <input
            type="text"
            class="formulario__input"
            placeholder="Nombre del ponente"
            id="ponente">
    </div>
    <ul class="listado-ponentes" id="listado-ponentes"></ul>
    <input type="hidden" name="ponente_id" value="<?php echo $evento->ponente_id;?>">

    <div class="formulario__campo">
        <label for="disponibles" class="formulario__label">Lugares disponebles:</label>
        <input
            type="number"
            min="1"
            class="formulario__input"
            placeholder="Ej. 20"
            name="disponibles"
            value="<?php echo $evento->disponibles ?? '';?>"
            id="disponibles">
    </div>
</fieldset>