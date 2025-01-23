<div class="main-container">
        <div class="login-image">
            <img src="./img/Sistema de inventarios.png" alt="Sistema de Inventarios">
        </div>

        <form class="box login-form" action="" method="post" autocomplete="off">
            <h5 class="title is-5 has-text-centered is-uppercase">Sistema de Inventario</h5>
            <div class="field">
                <label class="label" for="login">Usuario</label>
                <div class="control">
                    <input class="input" type="text" name="login_usuario" id="login" 
                           pattern="[a-zA-Z]{10,40}" maxlength="30" required 
                           placeholder="Ingresa tu usuario">
                </div>
            </div>

            <div class="field">
                <label class="label" for="password">Contraseña</label>
                <div class="control">
                    <input class="input" type="password" name="password_usuario" id="password" 
                           pattern="[a-zA-Z0-9$@.#]{12,100}" maxlength="100" required 
                           placeholder="Ingresa tu contraseña">
                </div>
            </div>
            
            <button type="submit" class="button is-info is-rounded">Iniciar Sesión</button>

            <?php 
                if(isset($_POST['login_usuario']) && isset($_POST['password_usuario'])){
                    require_once "./php/main.php";
                    require_once "./php/iniciar_sesion.php";
                }
            ?>
        </form>
        <p class="footer-text">© 2025 Sistema de Inventarios. Readaptado por Winston Guzmán.</p>
    </div>