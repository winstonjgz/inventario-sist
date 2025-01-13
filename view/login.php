<div class="main-container">

    <form class="box login" action="" method="post" autocomplete="off">
        <h5 class="title is-5 has-text-centered is-uppercase">Sistema de Inventario</h5>
        <div class="field">
            <label class="label" for="">Usuario</label>
            <div class="control">
                <input class="input" type="text" name="login_usuario" pattern="[a-zA-Z]{10,40}" id="login" maxlength="30" required>
            </div>
        </div>

        <div class="field">
            <label class="label" for="">Password</label>
            <div class="control">
                <input class="input" type="password" name="password_usuario" pattern="[a-zA-Z0-9$@.#]{12,100}" id="password" maxlength="100" required>
            </div>
        </div>
        
        <p class="has-text-centered mb-4 mt-3">
            <button type="submit" class="button is-info is-rounded">Iniciar Sesion</button>
        </p>

        <?php 
            if(isset($_POST['login_usuario']) && isset($_POST['password_usuario'])){
                require_once "./php/main.php";
                require_once "./php/iniciar_sesion.php";
                
            }
        ?>

    </form>

</div>