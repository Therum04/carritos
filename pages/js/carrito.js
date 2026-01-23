
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
/* document.querySelectorAll('.remove-item').forEach(btn => {
	btn.addEventListener('click', function () {
		const id = this.dataset.id;
		const item = this.closest('.cartItem');

		fetch('../pages/eliminar_cart.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: `id=${id}&accion=remove`
		})
			.then(r => r.json())
			.then(data => {
				if (!data.ok) return;

				
				item.remove();

			
				document.getElementById('subtotal').innerText = 'S/. ' + data.subtotal;
				document.getElementById('items').innerText = data.items;
				document.getElementById('total').innerText = 'S/. ' + data.total;
				document.getElementById('cartCount').innerText = data.items;
			});
	});
}); */
$(document).ready(function () {
	// Renderiza la tabla





});
