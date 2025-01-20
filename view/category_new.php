<div class="container is-fluid mb-6">
    <h1 class="title">Categoría</h1>
    <h2 class="subtitle">Nueva Categoría</h2>
</div>

<div class="container pb-6 pt-6">
    <div class="form-rest mb-6 mt-6"></div>
    <form action="./php/categoria_guardar.php" method="post" class="FormularioAjax" autocomplete="off">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label for="">Nombre</label>
                    <input class="input" type="text" name="categoria_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" >
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label for="">Ubicación</label>
                    <input class="input" type="text" name="categoria_ubicacion" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,50}" maxlength="50" >
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