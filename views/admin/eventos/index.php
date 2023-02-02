<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/eventos/crear">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Evento
    </a>
</div>

<div class="dashboard__contenedor table__contenedor">
    <?php if(!empty($eventos)){ ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Evento</th>
                    <th scope="col" class="table__th">Día y Hora</th>
                    <th scope="col" class="table__th">Orador</th>
                    <th scope="col" class="table__th">Acciones</th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($eventos as $evento){ ?>
                    <tr class="table__tr">
                        <td class="table__td"> 
                            <?php echo $evento->nombre . " - " . $evento->categoria->nombre; ?>
                        </td>
                        <td class="table__td"> 
                            <?php echo $evento->dia->nombre . ": " . $evento->hora->hora; ?>
                        </td>
                        <td class="table__td"> 
                            <?php echo $evento->ponente->nombre . " " . $evento->ponente->apellido; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/eventos/editar?id=<?php echo $evento->id; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>
                            <div class="table__formulario">
                                <button id="btn_eliminar_evento" data-id="<?php echo $evento->id; ?>" class="table__accion table__accion--eliminar">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No Hay Eventos Aún</p>
    <?php } ?>
</div>


<?php 

    echo $paginacion;

?>