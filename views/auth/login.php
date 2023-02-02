<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Inicia Sesión en DevWebCamp</p>

    <?php 
        include_once __DIR__ . '/../templates/alertas.php';
    ?>
    <form method="POST" action="/login" class="formulario">
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
        <div class="formulario__campo">
            <label for="password" class="formulario__label">Password</label>
            <input
                name="password" 
                type="password"
                class="formulario__input"
                placeholder="Ingrese su password"
                id="password"
            >
        </div>

        <input type="submit" class="formulario__submit" value="Iniciar Sesión">
    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Obten una</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu password?</a>
    </div>
</main>