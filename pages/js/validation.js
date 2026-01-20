$(document).ready(function () {
    $('#form_categoria').validate({
        rules: {
            categoria: {
                required: true,
                minlength: 2
            },
        },
        messages: {
            categoria: {
                required: "Campo obligatorio",
                minlength: "Mínimo 2 letras"
            },
        }
    });
});