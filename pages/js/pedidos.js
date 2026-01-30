
function load(page) {
	$(".outer_div2").html('');
	$("#loader2").html('').fadeIn('');
	var query = $("#q").val();
	var per_page = 10;
	var parametros = { "action": "ajax", "page": page, 'query': query, 'per_page': per_page };
	$("#loader").fadeIn('slow');
	$.ajax({
		method: 'POST',
		url: '../pages/pedidos_paginar.php',
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
function detalle(idpedido) {

	var parametros = { idpedido: idpedido };
	$("#loader2").fadeIn('slow');
	$.ajax({
		method: 'POST',
		url: '../pages/pedido_detalle.php',
		data: parametros,
		beforeSend: function (objeto) {
			$("#loader2").html("Cargando...");
		},
		success: function (data) {
			$(".outer_div2").html(data).fadeIn('slow');
			$("#loader2").html("");
		}
	});
}


$(document).ready(function () {
	// Renderiza la tabla
	load();
	$(document.body).on('click', '.ver-detalle', function () {
		var cid = $(this).data('cid');
		detalle(cid)
	});
});
