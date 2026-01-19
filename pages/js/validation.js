$(document).ready(function () {
    $.validator.addMethod("tieneEspecial", function (value, element) {
        return /[^a-zA-Z0-9]/.test(value); // al menos un caracter especial
    }, "Debe contener al menos un carácter especial");

    $('#add_empleado_form').validate({
        rules: {
            nombres: {
                required: true,
                minlength: 2
            },
            enun_perfil: {
                required: true,

            },
            usuario: {
                required: true,
                minlength: 3
            },
            clave: {
                required: true,
                minlength: 3,
                tieneEspecial: true
            },
        },
        messages: {
            nombres: {
                required: "Campo obligatorio",
                minlength: "Mínimo 2 letras"
            },
            enun_perfil: {
                required: "Rol es requerido"

            },
            usuario: {
                required: "Usuario obligatorio",
                minlength: "Mínimo 3 letras"
            },
            clave: {
                required: "Clave obligatorio",
                minlength: "Mínimo 3 letras",
                tieneEspecial: "Debe contener al menos un carácter especial"
            },
        }
    });

    $('#form_clientes').validate({
        rules: {
            nombre_completo: {
                required: true,
                minlength: 2
            },
            fecha_namiento: {
                required: true,

            },

            correo_electronico: {
                required: true,
                minlength: 3,
                email: true
            },
            fecha_namiento: {
                required: true,

            },
            clave: {
                required: true,
                minlength: 3,
                tieneEspecial: true
            },
            telefono: {
                required: true,
            },
            domicilio: {
                required: true,
            },
            enum_rol: {
                required: true,
            },
            foto: {
                /* required: function () {
                    return $("input[name='idestudiante']").val() == 0;
                } */
                required: false,
            },
        },
        messages: {
            nombre_completo: {
                required: "Campo es obligatorio",
                minlength: "Mínimo 2 letras"
            },
            fecha_namiento: {
                required: "Fecha de namiento es requerido"
            },
            correo_electronico: {
                required: "Correo electronico es requerido"
            },
            clave: {
                required: "Clave obligatorio",
                minlength: "Mínimo 3 letras",
                tieneEspecial: "Debe contener al menos un carácter especial"
            },
            telefono: {
                required: "Teléfono es requerido"
            },
            domicilio: {
                required: "Domicilio es requerido"
            },
            enum_rol: {
                required: "Tipo de rol es requerido"
            },
            foto: {
                required: "Foto es requerido"
            },
        }
    });

    $('#form_paquete').validate({
        rules: {
            nombre: {
                required: true,
            },
            descripcion: {
                required: true,

            },
            fecha_inicio: {
                required: true,

            },
            fecha_fin: {
                required: true,

            },
            cantidad_clases: {
                required: true,

            },
            precio: {
                required: true,

            },
            descuento: {
                required: true,

            },
            paquete_vigencia: {
                required: true,

            },
            habilitado: {
                required: true,

            },

        },
        messages: {
            nombre: {
                required: "Nombre es obligatorio",

            },
            descripcion: {
                required: "Descripción es requerido"

            },
            fecha_inicio: {
                required: "Fecha de inicio es obligatorio",

            },
            fecha_fin: {
                required: "Fecha de fin es obligatorio",

            },
            cantidad_clases: {
                required: "Cantidad es obligatorio",

            },
            precio: {
                required: "Precio es obligatorio",

            },
            descuento: {
                required: "Descuento es obligatorio",

            },
            paquete_vigencia: {
                required: "Paguetes Vigencia es obligatorio",

            },
            habilitado: {
                required: "Habilitado es obligatorio",

            },

        }
    });

    $('#form_curso').validate({
        rules: {

            asignatura: {
                required: true,
                minlength: 3,
            },

        },
        messages: {

            asignatura: {
                required: "Asignatura es obligatorio",

            },

        }
    });
    $('#add_curso_form').validate({
        rules: {

            nombre: {
                required: true,
                minlength: 3,
            },
            descripcion: {
                required: true,

            },
            elegir_lugar: {
                required: true,

            },

        },
        messages: {

            nombre: {
                required: "Nombre es obligatorio",

            },
            descripcion: {
                required: "Descripción es obligatorio",
            },
            elegir_lugar: {
                required: "Elegir Lugar es obligatorio",
            },

        }
    });
    $('#add_libro_form').validate({
        rules: {
            titulo: {
                required: true,

            },
            autor: {
                required: true,
                minlength: 3,
            },
            precio: {
                required: true,
            },
            descripcion: {
                required: true,
                minlength: 3,
            },
            pdf: {
                required: true,
            },
        },
        messages: {
            titulo: {
                required: "Título curso es obligatorio",
            },
            autor: {
                required: "Autor es obligatorio",
            },
            precio: {
                required: "Precio es obligatorio",
            },
            descripcion: {
                required: "Descripción es obligatorio",
            },
            pdf: {
                required: "PDF es obligatorio",
            },
        }
    });
    $('#add_temarios_form').validate({
        rules: {
            idcursos: {
                required: true,

            },
            titulo: {
                required: true,
                minlength: 3,
            },
            descripcion: {
                required: true,
                minlength: 3,
            },
        },
        messages: {
            idcursos: {
                required: "Seleccione curso es obligatorio",
            },
            titulo: {
                required: "Titulo es obligatorio",
            },
            descripcion: {
                required: "Descripción es obligatorio",
            },
        }
    });
    $('#form_comprar').validate({
        rules: {
            fecha_reserva: {
                required: true,

            },
            vigencia: {
                required: false,
            }

        },
        messages: {
            fecha_reserva: {
                required: "Seleccione fecha es obligatorio",
            },
            vigencia: {
                required: "Vigencia es obligatorio",
            },

        }
    });
    $('#add_programacion_form').validate({
        rules: {
            idestudiante: {
                required: true,

            },
            idcursos: {
                required: true,
            },
            fecha_hora: {
                required: true,
            },
            cupo: {
                required: true,
            }

        },
        messages: {
            idestudiante: {
                required: "Seleccione profesor es obligatorio",
            },
            idcursos: {
                required: "Seleccione cursos es obligatorio",
            },
            fecha_hora: {
                required: "Fecha y hora es obligatorio",
            },
            cupo: {
                required: "Cupo es obligatorio",
            },

        }
    });
    $('#form_banco').validate({
        rules: {
            tipo_pago: {
                required: true,

            },


        },
        messages: {
            tipo_pago: {
                required: "Seleccione banco es obligatorio",
            },


        }
    });

    $('#add_clases_form').validate({
        rules: {
            titulo: {
                required: true,
                minlength: 3,
            },
            video_url: {
                required: true,
                minlength: 3,
            },
            pdf_url: {
                required: true,

            },
            descripcion: {
                required: true,
                minlength: 3,
            },


        },
        messages: {
            titulo: {
                required: "Titulo es obligatorio",
            },
            video_url: {
                required: "Url de video es obligatorio",
            },
            pdf_url: {
                required: "PDF es obligatorio",
            },
            descripcion: {
                required: "Descripción es obligatorio",
            },


        }
    });
    $('#form_reserva').validate({
        rules: {
            idpaquetes: {
                required: true,
            },
            idcursos: {
                required: true,
            },
            fecha_reserva: {
                required: true,
            },
        },
        messages: {
            idpaquetes: {
                required: "Paquete es obligatorio",
            },
            idcursos: {
                required: "Curso es obligatorio",
            },
            fecha_reserva: {
                required: "Fecha de reserva es obligatorio",
            },
        }
    });

});