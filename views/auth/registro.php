


<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Regístrate en DevWebCamp</p>

    <?php 
        require_once __DIR__ . '/../templates/alertas.php';
    ?>
    <form method="POST" action="/registro" class="formulario">
        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombre</label>
            <input
                name="nombre" 
                type="text"
                class="formulario__input"
                placeholder="Ingrese su nombre"
                id="nombre"
                value="<?php echo $usuario->nombre; ?>"
            >
        </div>

        <div class="formulario__campo">
            <label for="apellido" class="formulario__label">Apellido</label>
            <input
                name="apellido" 
                type="text"
                class="formulario__input"
                placeholder="Ingrese su apellido"
                id="apellido"
                value="<?php echo $usuario->apellido; ?>"
            >
        </div>
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input
                name="email" 
                type="email"
                class="formulario__input"
                placeholder="Ingrese su email"
                id="email"
                value="<?php echo $usuario->email; ?>"
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

        <div class="formulario__campo">
            <label for="password2" class="formulario__label">Repetir Password</label>
            <input
                name="password2" 
                type="password"
                class="formulario__input"
                placeholder="Ingrese su password"
                id="password2"
            >
        </div>

        <input type="submit" class="formulario__submit" value="Crear Cuenta">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Iniciar Sesión</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu password?</a>
    </div>
</main>