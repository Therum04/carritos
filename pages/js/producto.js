
function load(page) {
	var query = $("#q").val();
	var per_page = 10;
	var parametros = { "action": "ajax", "page": page, 'query': query, 'per_page': per_page };
	$("#loader").fadeIn('slow');
	$.ajax({
		method: 'POST',
		url: '../pages/producto_paginar.php',
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

function openModal() {
	document.getElementById('modalProducto').classList.remove('hidden');
}

function closeModal() {
	document.getElementById('modalProducto').classList.add('hidden');
}

function openModalDetalle() {
	document.getElementById('productoModal').classList.remove('hidden');
}

function closeModalDetalle() {
	document.getElementById('productoModal').classList.add('hidden');
}

function calcularDescuento() {
	const precio = parseFloat(document.getElementById('precio').value);
	const oferta = parseFloat(document.getElementById('precio_oferta').value);

	if (precio > 0 && oferta >= 0) {
		const descuento = ((precio - oferta) / precio) * 100;
		document.getElementById('descuento').value = Math.round(descuento);
	}
}
document.querySelectorAll('.thumb').forEach(thumb => {
	thumb.addEventListener('click', () => {
		document.getElementById('mainImg').src =
			thumb.querySelector('img').src;

		document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
		thumb.classList.add('active');
	});
});

function scrollThumbs(px) {
	document.getElementById('thumbs').scrollLeft += px;
}
let selectedFiles = [];

function previewGallery(event) {
	const files = Array.from(event.target.files);
	const preview = document.getElementById('galleryPreview');

	// Limpiar
	preview.innerHTML = '';
	selectedFiles = [];

	// Límite
	if (files.length > 6) {
		toastr.error('Solo puedes subir hasta 6 imágenes');
		event.target.value = '';
		return;
	}

	files.forEach((file, index) => {
		// Validar imagen
		if (!file.type.startsWith('image/')) return;

		selectedFiles.push(file);

		const reader = new FileReader();
		reader.onload = e => {
			const div = document.createElement('div');
			div.className = 'relative group';

			div.innerHTML = `
        <img src="${e.target.result}"
             class="w-full h-24 object-cover rounded-lg border">

        <button type="button"
          class="absolute top-1 right-1 bg-red-600 text-white text-xs
                 rounded-full w-6 h-6 hidden group-hover:flex
                 items-center justify-center"
          onclick="removeImage(${index})">
          ✕
        </button>
      `;

			preview.appendChild(div);
		};
		reader.readAsDataURL(file);
	});
}

// Eliminar imagen del preview
function removeImage(index) {
	selectedFiles.splice(index, 1);

	const input = document.querySelector('input[name="galeria[]"]');
	const dataTransfer = new DataTransfer();

	selectedFiles.forEach(file => dataTransfer.items.add(file));
	input.files = dataTransfer.files;

	previewGallery({ target: input });
}
function previewPrincipal(e) {
	const file = e.target.files[0];
	if (!file) return;

	document.getElementById('txtPrincipal').innerText =
		'Seleccionada: ' + file.name;
	document.getElementById('txtPrincipal').classList.remove('hidden');
	document.getElementById('btnQuitarPrincipal').classList.remove('hidden');
}

function clearPrincipal() {
	const input = document.getElementById('imgPrincipal');
	input.value = '';

	document.getElementById('txtPrincipal').classList.add('hidden');
	document.getElementById('btnQuitarPrincipal').classList.add('hidden');
}
let thumbIndex = 0;
const visibleThumbs = 10;
const thumbWidth = 72; // 64px + 8px gap

function scrollThumbs(dir) {
	const thumbs = document.querySelectorAll('#thumbs .thumb');
	const total = thumbs.length;

	thumbIndex += dir;

	if (thumbIndex < 0) thumbIndex = 0;
	if (thumbIndex > total - visibleThumbs) {
		thumbIndex = total - visibleThumbs;
	}

	const offset = thumbIndex * thumbWidth;
	document.getElementById('thumbs').style.transform =
		`translateX(-${offset}px)`;
}
function changeMainImg(img) {
	$('#mainImg').attr('src', '../img/' + img);
}
$(document).ready(function () {
	// Renderiza la tabla


	load();

	function getCategoria() {
		$.ajax({
			url: '../admin/classes/Categoria.php',
			method: 'POST',
			data: { GET_CATEGORIAS: 1 },
			success: function (response) {
				var resp = $.parseJSON(response);
				if (resp.status == 202) {

					var catSelectHTML = '<option value="">Seleccione</option>';
					$.each(resp.message.enumerado, function (index, value) {
						catSelectHTML += '<option value="' + value.idcategorias + '">' + value.categoria + '</option>';
					});
					$(".tipoCategoria_list").html(catSelectHTML);

				}
			}
		});
	}
	getCategoria();



	$(".add-insert").on("click", function () {
		if ($('#productoForm').valid() == false) {
			return;
		}
		$.ajax({
			url: '../admin/classes/Producto.php',
			type: 'POST',
			data: new FormData($("#productoForm")[0]),
			contentType: false,
			processData: false,
			cache: false,
			success: function (response) {
				let resp = JSON.parse(response);
				if (resp.status == 202) {
					load();
					$('#productoForm')[0].reset();
					toastr.success(resp.message);
				} else {
					toastr.error(resp.message);
				}
				closeModal();
			},
			error: function (xhr) {
				console.error(xhr.responseText);
			}
		});



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
	$(document.body).on('click', '.ver-detalle', function () {
		var cid = $(this).data('cid');
		$.ajax({
			url: '../pages/producto_detalle.php',
			type: 'POST',
			data: { idproducto: cid },
			dataType: 'json',
			success: function (res) {
				// TEXTO
				$('#productoModal h2').text(res.nombre);
				$('#productoModal .precio').text('S/. ' + res.precio);
				$('#productoModal .precio_old').text('S/. ' + res.precio_oferta);
				$('#productoModal .descripcion').text(res.descripcion);
				if (res.descuento && res.descuento !== '0%' && res.descuento !== '') {
					$('#productoModal .descuento')
						.text(`-${res.descuento}%`)
						.removeClass('hidden');
				} else {
					$('#productoModal .descuento').addClass('hidden');
				}
				// IMAGEN PRINCIPAL
				$('#mainImg').attr('src', '../img/' + res.imagen_principal);
				// GALERÍA
				let thumbs = '';
				res.galeria.forEach(img => {
					thumbs += `
      <div class="thumb">
		 <img src="../img/${img}"
          class="w-16 h-16 object-cover rounded-lg cursor-pointer border border-gray-300 hover:border-green-500"
          onclick="changeMainImg('../img/${img}')">
      </div>
    `;
				});
				$('#thumbs').html(thumbs);

				openModalDetalle();
			}
		});
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
