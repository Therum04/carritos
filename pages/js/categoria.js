
function load(page) {
	var query = $("#q").val();
	var per_page = 10;
	var parametros = { "action": "ajax", "page": page, 'query': query, 'per_page': per_page };
	$("#loader").fadeIn('slow');
	$.ajax({
		method: 'POST',
		url: '../pages/categoria_paginar.php',
		data: parametros,
		beforeSend: function (objeto) {
			$("#loader").html("Cargando...");
		},
		success: function (data) {
			$(".outer_div").html(data).fadeIn('slow');
			$("#loader").html("");
		}
	});
}

function abrirCategoria() {
	$("input[name='idcategorias']").val(0);
	document.getElementById('categoriaModal').classList.remove('hidden');
}
function cerrarCategoriaModal() {
	document.getElementById('categoriaModal').classList.add('hidden');
}
$(document).ready(function () {
	// Renderiza la tabla


	load();




	$(".add-insert-upadate").on("click", function () {
		if ($('#form_categoria').valid() == false) {
			return;
		}
		$.ajax({
			url: '../admin/classes/Categoria.php',
			method: 'POST',
			data: $("#form_categoria").serialize(),
			success: function (response) {
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					load();
					$('#form_categoria').trigger("reset");
					toastr.success(resp.message);
				} else if (resp.status == 303) {
					toastr.error(resp.message);
				}
				cerrarCategoriaModal();
			}
		})
	});
	$(document.body).on("click", ".edit-registro", function () {
		var categorias = $.parseJSON($.trim($(this).children("span").html()));
		$("input[name='idcategorias']").val(categorias.idcategorias);
		$("input[name='categoria']").val(categorias.categoria);
		document.getElementById('categoriaModal').classList.remove('hidden');
	});

	$(document.body).on('click', '.delete-almacen', function () {
		var cid = $(this).data('cid');
		$("input[name='cid']").val(cid);
		$("#deleteAlmacenModals").modal('show');
	});

	$(".delete-almacen-btn").on('click', function () {
		$.ajax({
			url: '../admin/classes/Almacen.php',
			method: 'POST',
			data: $("#delete_almacen_form").serialize(),
			success: function (response) {
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					$("#message").html(`<div class="alert alert-info alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							`+ resp.message + `
						</div>`
					);
					load(1);
				} else if (resp.status == 303) {
					$("#message").html(`<div class="alert alert-info alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							`+ resp.message + `
						</div>`
					);
				}
				$("#deleteAlmacenModals").modal('hide');

			}
		});
	});

});
