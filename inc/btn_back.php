<p class="has-text-right pb-4 pt-4">
    <a href="" class=" button btn-back is-link is-rounded"> ⏪ Regresar atrás</a>
</p>
<script type="text/javascript">
    let btn_back = document.querySelector('.btn-back');
    btn_back.addEventListener('click', function(e) {
        e.preventDefault();
        window.history.back();
    });
</script>