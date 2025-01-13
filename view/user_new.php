<div class="container is-fluid mb-6">
    <h1 class="title">Usuario</h1>
    <h2 class="subtitle">Nuevo Usuario</h2>
</div>

<div class="container pb-6 pt-6">
    <div class="form-rest mb-6 mt-6"></div>
    <form action="./php/usuario_guardar.php" method="post" class="FormularioAjax" autocomplete="off">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label for="">Nombre</label>
                    <input class="input" type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" >
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">Apellido</label>
                    <input class="input" type="text" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" >
                </div>
            </div>
        </div>
        <div class="columns">

            <div class="column">
                <div class="control">
                    <label for="">Usuario</label>
                    <input class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z]{10,40}" maxlength="40" >
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">email</label>
                    <input class="input" type="email" name="usuario_email" maxlength="70" >
                </div>
            </div>


        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label for="">Password</label>
                    <input class="input" type="password" name="usuario_password_1" pattern="[a-zA-Z0-9$@.#]{12,100}" maxlength="100" >
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">Repetir Password</label>
                    <input class="input" type="password" name="usuario_password_2" pattern="[a-zA-Z0-9$@.#]{12,100}" maxlength="100" >
                </div>
            </div>

        </div>

</div>
    <p class="has-text-centered">
        <button type="submit" class="button is-info is-rounded">
            Guardar

        </button>
    </p>

</form>
</div>