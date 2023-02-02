<main class="agenda">
    <h2 class="agenda__heading"><?php echo $evento->nombre . ", " . $evento->categoria->nombre; ?></h2>
    <p class="agenda__descripcion">Descubra más sobre este taller</p>

    <div class="agenda__contenido">
        <p class="agenda__fecha">Día y Hora: <?php echo $evento->dia->nombre . ", " . $evento->hora->hora; ?></p>
        <p class="agenda__lugares">Lugares Disponibles: <?php echo $evento->disponibles; ?></p>
        <p class="agenda__texto"><?php echo $evento->descripcion; ?></p>
    </div>
    
    <h2 class="agenda__heading">Orador del Evento</h2>
    
    <div class="agenda__orador">    
        <picture>
            <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $evento->ponente->imagen; ?>.webp" type="image/webp">
            <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $evento->ponente->imagen; ?>.png" type="image/png">
            <img loading="lazy" width="200" height="300" class="<?php echo ($evento->categoria->nombre === 'Conferencias') ? 'agenda__imagen-autor' : 'agenda__imagen-autor--workshop' ?>" src="<?php echo $_ENV['HOST'] . '/img/speakers/' . $evento->ponente->imagen; ?>.png" alt="Imagen Ponente">
        </picture>
        <div class="agenda__datos">
            <p class="<?php echo ($evento->categoria->nombre === 'Conferencias') ? 'agenda__nombre-orador' : 'agenda__nombre-orador--workshop'; ?>"><?php echo $evento->ponente->nombre . " " . $evento->ponente->apellido; ?></p>
            
            <ul class="<?php echo ($evento->categoria->nombre === 'Conferencias') ? 'agenda__listado-skills' : 'agenda__listado-skills--workshop'; ?>">
                <?php 
                    $tags = explode(',',$evento->ponente->tags);
                    foreach($tags as $tag) { 
                ?>
                    <li class="agenda__skill"><?php echo $tag; ?></li>
                <?php }?>
            </ul>
        </div>
    </div>

    <a class="agenda__enlace-volver" href="/workshops">
        <i class="fa-solid fa-circle-arrow-left"></i>    
        Volver
    </a>
</main>