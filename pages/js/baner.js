
function load(page) {
	var query = null;
	var per_page = 10;
	var parametros = { "action": "ajax", "page": page, 'query': query, 'per_page': per_page };
	$("#loader").fadeIn('slow');
	$.ajax({
		method: 'POST',
		url: '../pages/baner_paginar.php',
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

function abrirBanner() {
	document.getElementById('bannerModal').classList.remove('hidden');
}
function cerrarBanner() {
	document.getElementById('bannerModal').classList.add('hidden');
}
function cancelarEliminar() {
	document.getElementById('deleteModal').classList.add('hidden');
}
$(document).ready(function () {
	// Renderiza la tabla


	load();




	$(".add-insert-upadate").on("click", function () {
		if ($('#form_baner').valid() == false) {
			return;
		}
		$.ajax({
			url: '../admin/classes/Baner.php',
			method: 'POST',
			data: new FormData($("#form_baner")[0]),
			contentType: false,
			processData: false,
			cache: false,
			success: function (response) {
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					load();
					$('#form_baner').trigger("reset");
					toastr.success(resp.message);
				} else if (resp.status == 303) {
					toastr.error(resp.message);
				}
				cerrarBanner();
			}
		})
	});
	$(document.body).on("click", ".edit-registro", function () {
		var categorias = $.parseJSON($.trim($(this).children("span").html()));
		$("input[name='idcategorias']").val(categorias.idcategorias);
		$("input[name='categoria']").val(categorias.categoria);
		document.getElementById('categoriaModal').classList.remove('hidden');
	});

	$(document.body).on('click', '.delete-registro', function () {
		var cid = $(this).data('cid');
		$("input[name='cid']").val(cid);
		document.getElementById('deleteModal').classList.remove('hidden');
	});

	$(".delete-registro-btn").on('click', function (e) {
		e.preventDefault();
		$.ajax({
			url: '../admin/classes/Categoria.php',
			method: 'POST',
			data: $("#delete_registro_form").serialize(),
			success: function (response) {
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					toastr.success(resp.message);
					load(1);
				} else if (resp.status == 303) {
					toastr.error(resp.message);
				}
				cancelarEliminar();

			}
		});
	});

});
