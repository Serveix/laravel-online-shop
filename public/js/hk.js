function updateOrderStatus(form) {
	return jQuery.ajax({
		url: '/housekeeping/orders/update/status',
		type: 'post',
		data: form.serialize(),
	});
}