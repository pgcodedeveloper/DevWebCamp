<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $titulo; ?></h2>
    <p class="devwebcamp__descripcion">Conoce sobre la conferencia más importante de Latinoamérica</p>

    <div class="devwebcamp__grid">
        <div data-aos="<?php aos_animacion(); ?>" class="devwebcamp__imagen">
            <picture>
                <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img src="build/img/sobre_devwebcamp.jpg" loading="lazy" width="200" height="300" alt="Sobre Nosotros">
            </picture>
        </div>

        <div data-aos="<?php aos_animacion(); ?>" class="devwebcamp__contenido">
            <p class="devwebcamp__texto">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ornare fermentum porttitor. Nulla pretium
                vehicula massa ac vestibulum. Sed pharetra risus eget faucibus pharetra. In accumsan libero sed rutrum
                porta. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed
                rhoncus tortor nec sapien molestie semper. Sed ante risus, congue eget semper a, cursus id dolor.
                Vestibulum venenatis sapien nec nunc commodo, quis interdum diam tincidunt.
            </p>
            <p class="devwebcamp__texto">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut ornare fermentum porttitor. Nulla pretium
                vehicula massa ac vestibulum. Sed pharetra risus eget faucibus pharetra. In accumsan libero sed rutrum
                porta. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
            </p>
        </div>
    </div>
</main>