<div class="evento swiper-slide">
    <p class="evento__hora"><?php echo $evento->hora->hora; ?></p>

    <div class="evento__info">
        <a href="<?php echo "/workshops/evento?id=" . $evento->id; ?>" class="evento__nombre"><?php echo $evento->nombre; ?></a>

        <div>
            <p class="evento__intro"><?php echo $evento->descripcion; ?></p>
        </div>

        <div class="evento__autor-info">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $evento->ponente->imagen; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/speakers/' . $evento->ponente->imagen; ?>.png" type="image/png">
                <img loading="lazy" width="200" height="300" class="evento__imagen-autor" src="<?php echo $_ENV['HOST'] . '/img/speakers/' . $evento->ponente->imagen; ?>.png" alt="Imagen Ponente">
            </picture>

            <p class="evento__autor-nombre">
                <?php echo $evento->ponente->nombre . " " . $evento->ponente->apellido; ?>
            </p>
        </div>
    </div>
</div>