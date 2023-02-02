<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Recupera tu Password en DevWebCamp</p>

    <?php 
        include_once __DIR__ . '/../templates/alertas.php';
    ?>
    <form method="POST" action="/olvide" class="formulario">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input
                name="email" 
                type="email"
                class="formulario__input"
                placeholder="Ingrese su email"
                id="email"
            >
        </div>
        <input type="submit" class="formulario__submit" value="Enviar Instrucciones">
    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Obten una</a>
        <a href="/login" class="acciones__enlace">¿Ya tienes un cuenta? Iniciar Sesión</a>
    </div>
</main>