
document.querySelectorAll('.cartItem').forEach(item => {
	const id = item.dataset.id;

	item.querySelector('.qty-inc').onclick = () => updateQty(id, 'inc', item);
	item.querySelector('.qty-dec').onclick = () => updateQty(id, 'dec', item);
});

function updateQty(id, accion, item) {
	const precio = parseFloat(item.dataset.price);
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
				const subtotalItem = precio * data.cantidad;
				item.querySelector('.itemSubtotal').innerText =
					'S/. ' + subtotalItem.toFixed(2);
			}

			document.getElementById('subtotal').innerText = 'S/. ' + data.subtotal;
			document.getElementById('items').innerText = data.items;
			document.getElementById('total').innerText = 'S/. ' + data.total;
			document.getElementById('cartCount').innerText = data.items;
		});
}

/*
document.addEventListener('click', function(e) {
  const btn = e.target.closest('.remove-item');
  if (!btn) return;

  const id = btn.dataset.id;
  const cartItem = btn.closest('.cartItem');

  const formData = new FormData();
  formData.append('id', id);
  formData.append('accion', 'remove');

  fetch('../pages/eliminar_cart.php', {
	method: 'POST',
	body: formData
  })
  .then(r => r.json())
  .then(data => {
	if (!data.ok) return;

	// 🧹 1. Quitar item del DOM
	if (cartItem) cartItem.remove();

	// 🔄 2. Actualizar totales
	document.getElementById('subtotal').textContent = 'S/. ' + data.subtotal;
	document.getElementById('total').textContent    = 'S/. ' + data.total;
	document.getElementById('items').textContent    = data.items;
	document.getElementById('cartCount').textContent = data.items;

	// 🔔 3. Actualizar badge del menú
	updateCartBadge(data.items);

	// 📭 4. Si ya no hay items, mostrar vacío
	if (data.items == 0) {
	  const cartBody = document.getElementById('cartBody');
	  cartBody.innerHTML = `
		<div class="p-8 text-center text-gray-500">
		  🛒 Tu carrito está vacío
		</div>
	  `;
	}
  })
  .catch(err => console.error('Remove error:', err));
});
*/
// ===============================
// BADGE DEL CARRITO
// ===============================
function updateCartBadge(total) {
	const badge = document.getElementById('cartBadge');
	if (!badge) return;

	total = parseInt(total) || 0;
	badge.textContent = total;

	if (total > 0) {
		badge.classList.remove('hidden');
		// pequeña animación
		badge.classList.add('scale-110');
		setTimeout(() => badge.classList.remove('scale-110'), 150);
	} else {
		badge.classList.add('hidden');
	}
}


// ===============================
// (OPCIONAL) ACTUALIZAR TOTALES EN CARRITO.PHP
// ===============================
function updateTotalsUI(data) {
	if (document.getElementById('subtotal')) {
		document.getElementById('subtotal').textContent = data.subtotal;
	}
	if (document.getElementById('total')) {
		document.getElementById('total').textContent = data.total;
	}
}
$(document).ready(function () {
	// Renderiza la tabla


	$(document.body).on('click', '.remove-item', function (e) {

		const btn = e.target.closest('.remove-item');
		var id = $(this).data('id');
		const cartItem = btn.closest('.cartItem');
		const formData = new FormData();
		formData.append('id', id);
		formData.append('accion', 'remove');
		fetch('../pages/eliminar_cart.php', {
			method: 'POST',
			body: formData
		})
			.then(r => r.json())
			.then(data => {
				if (!data.ok) return;
				// 🧹 1. Quitar item del DOM
				if (cartItem) cartItem.remove();
				// 🔄 2. Actualizar totales
				document.getElementById('subtotal').textContent = 'S/. ' + data.subtotal;
				document.getElementById('total').textContent = 'S/. ' + data.total;
				document.getElementById('items').textContent = data.items;
				document.getElementById('cartCount').textContent = data.items;
				// 🔔 3. Actualizar badge del menú
				updateCartBadge(data.items);
				// 📭 4. Si ya no hay items, mostrar vacío
				if (data.items == 0) {
					const cartBody = document.getElementById('cartBody');
					cartBody.innerHTML = `
        <div class="p-8 text-center text-gray-500">
          🛒 Tu carrito está vacío
        </div>
      `;
				}
			})
			.catch(err => console.error('Remove error:', err));

	});


});
