
function load(page) {
	var query = null;
	var per_page = 10;
	var parametros = { "action": "ajax", "page": page, 'query': query, 'per_page': per_page };
	$("#loader").fadeIn('slow');
	$.ajax({
		method: 'POST',
		url: '../pages/presentacion_paginar.php',
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
document.addEventListener('click', function (e) {
	const btn = e.target.closest('.add-to-cart');
	if (!btn) return;

	const formData = new FormData();
	formData.append('id', btn.dataset.id);
	formData.append('name', btn.dataset.name);
	formData.append('price', btn.dataset.price);
	formData.append('image', btn.dataset.image);

	fetch('../pages/add_to_cart.php', {
		method: 'POST',
		body: formData
	})
		.then(r => r.json())
		.then(data => {
			if (data.ok) {
				updateCartBadge(data.total);
			}
		});
});
function updateCartBadge(total) {
	const badge = document.getElementById('cartBadge');
	if (!badge) return;

	badge.textContent = total;

	if (total > 0) {
		badge.classList.remove('hidden');
		// animación simple
		badge.classList.add('scale-125');
		setTimeout(() => badge.classList.remove('scale-125'), 150);
	} else {
		badge.classList.add('hidden');
	}
}
document.querySelectorAll('.cartItem').forEach(item => {
	const id = item.dataset.id;

	item.querySelector('.qty-inc').onclick = () => updateQty(id, 'inc', item);
	item.querySelector('.qty-dec').onclick = () => updateQty(id, 'dec', item);
});

function updateQty(id, accion, item) {
	fetch('../pages/carrito_action.php', {
		method: 'POST',
		headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
		body: `id=${id}&accion=${accion}`
	})
		.then(r => r.json())
		.then(data => {
			if (!data.ok) return;

			if (data.cantidad === 0) {
				item.remove();
			} else {
				item.querySelector('.qty-input').value = data.cantidad;
				item.querySelector('.itemSubtotal').innerText =
					'S/. ' + (12 * data.cantidad).toFixed(2);
			}

			document.getElementById('subtotal').innerText = 'S/. ' + data.subtotal;
			document.getElementById('items').innerText = data.items;
			document.getElementById('total').innerText = 'S/. ' + data.total;
			document.getElementById('cartCount').innerText = data.items;
		});
}
function openModalDetalle() {
	document.getElementById('productoModal').classList.remove('hidden');
}

function closeModalDetalle() {
	document.getElementById('productoModal').classList.add('hidden');
}
function changeMainImg(img) {
	$('#mainImg').attr('src', '../img/' + img);
}
$(document).ready(function () {
	// Renderiza la tabla
	load();
	$(document.body).on('click', '.view-product', function () {
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

});
