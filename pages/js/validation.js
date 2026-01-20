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
    $('#productoForm').validate({
       
        rules: {
            nombre: {
                required: true,
                minlength: 2
            },
            descripcion: {
                required: true,
                minlength: 2
            },
            idcategorias: {
                required: true,
            },
            precio: {
                required: true,
            },
           
        },
        messages: {
            nombre: {
                required: "Campo obligatorio",
                minlength: "Mínimo 2 letras"
            },
            descripcion: {
                required: "Campo obligatorio",
                minlength: "Mínimo 2 letras"
            },
            idcategorias: {
                required: "Campo obligatorio"
            },
            precio: {
                required: "Campo obligatorio"
            },
           
        }
    });
});