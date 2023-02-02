<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Evento</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre Evento</label>
        <input 
            type="text"
            class="formulario__input"
            name="nombre"
            id="nombre"
            placeholder="Ingrese el nombre del Evento"
            value="<?php echo $evento->nombre ?? ''; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripción</label>
        <textarea
            class="formulario__input"
            name="descripcion"
            id="descripcion"
            placeholder="Ingrese una descripción del Evento"
            rows="8"
        ><?php echo $evento->descripcion ?? ''; ?></textarea>
    </div>

    <div class="formulario__campo">
        <label for="categorias" class="formulario__label">Categorias o Tipo de Evento</label>
        <select
            id="categorias" 
            name="categoria_id"
            class="formulario__select"
        >
            <option value="">-- Seleccionar --</option>
            <?php foreach($categorias as $categoria) { ?>
                <option <?php echo ($evento->categoria_id === $categoria->id) ? 'selected' : ''; ?> value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="dia" class="formulario__label">Selecciona el día</label>
        
        <div class="formulario__radio">
            <?php foreach($dias as $dia) { ?>
                <div class="formulario__radio--descripcion">
                    <label for="<?php echo strtolower($dia->nombre); ?>"><?php echo $dia->nombre; ?></label>
                    <input 
                        type="radio" 
                        name="dia" 
                        value="<?php echo $dia->id; ?>" 
                        id="<?php echo strtolower($dia->nombre); ?>"
                        <?php echo ($evento->dia_id === $dia->id) ? 'checked' : ''; ?>
                    >
                </div>
            <?php } ?>
        </div>

        <input type="hidden" name="dia_id" value="<?php echo $evento->dia_id; ?>">
    </div>

    <div class="formulario__campo">
        <label for="hora" class="formulario__label">Selecciona el horario</label>
        
        <ul id="horas" class="horas">
            <?php foreach($horas as $hora) { ?>
                <li data-hora-id="<?php echo $hora->id; ?>" class="horas__hora horas__hora--deshabilitadas"><?php echo $hora->hora; ?></li>
            <?php } ?>
        </ul>
        <input type="hidden" name="hora_id" value="<?php echo $evento->hora_id; ?>">
    </div>
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Extra</legend>
            
    <div class="formulario__campo">
        <label for="ponentes" class="formulario__label">Orador / Ponente</label>
        <input 
            type="text"
            class="formulario__input"
            id="ponentes"
            placeholder="Buscar Ponente"
        >
        <ul id="listado-ponentes" class="listado-ponentes"></ul>
        <input type="hidden" name="ponente_id" value="<?php echo $evento->ponente_id; ?>">
    </div>

    <div class="formulario__campo">
        <label for="disponibles" class="formulario__label">Lugares Disponibles</label>
        <input 
            type="number"
            min="1"
            class="formulario__input"
            id="disponibles"
            name="disponibles"
            placeholder="Ej: 20"
            value="<?php echo $evento->disponibles ?? 0; ?>"
        >
    </div>

</fieldset>