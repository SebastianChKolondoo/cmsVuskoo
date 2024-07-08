$(document).ready(function () {
	const tiempoCupon = document.getElementById('TiempoCupon');
	const fechaExpiracionField = document.getElementById('field_fecha_expiracion');

	function toggleFechaExpiracion() {
		if (tiempoCupon.value == '2') {
			fechaExpiracionField.classList.add('d-none');
		} else {
			fechaExpiracionField.classList.remove('d-none');
		}
	}
	// Escucha el cambio en el select
	tiempoCupon.addEventListener('change', toggleFechaExpiracion);

	// Inicializa el estado correcto cuando la página se carga
	toggleFechaExpiracion();
	
	const tipoCupon = document.getElementById('tipoCupon');
	const codigoCupon = document.getElementById('field_codigo_cupon');

	function toggleTipoCupon() {
		if (tipoCupon.value == '3') {
			codigoCupon.classList.remove('d-none');
		} else {
			codigoCupon.classList.add('d-none');
		}
	}
	// Escucha el cambio en el select
	tiempoCupon.addEventListener('change', toggleTipoCupon);

	// Inicializa el estado correcto cuando la página se carga
	toggleTipoCupon();

	$('.btn_save_info').on('click', () => {
		$('#loadInfo').modal({
			keyboard: false,
			backdrop: 'static',
		})
	});

	$("#sidebarToggle, #sidebarToggleTop").on('click', () => {
		$("body").toggleClass("sidebar-toggled");
		$(".sidebar").toggleClass("toggled");
		if ($(".sidebar").hasClass("toggled")) {
			$('.sidebar .collapse').collapse('hide');
		};
	});

	$('#TiempoCupon').change(function () {
		if ($(this).val() == 1) {
			$('#field_fecha_expiracion').removeClass('d-none');
		}
		else {
			$('#field_fecha_expiracion').addClass('d-none');
		}
	});

	$('#tipoCupon').change(function () {
		if ($(this).val() == 3) {
			$('#field_codigo_cupon').removeClass('d-none');
		}
		else {
			$('#field_codigo_cupon').addClass('d-none');
		}
	});

	$('#comercio').change(function () {
		cargarPaisesComercio($(this).val());
	});

	$('#pais').change(function () {
		cargarPaisesCategorias($(this).val());
	});
});

let collapseContainers = false;

function cargarPaisesComercio(id) {
	$('#pais').html('<option>Cargando...</option>');
	$('#categoria').html('<option>Cargando...</option>');
	let url = '/api/cargarPaises';
	if (id) {
		url += '/' + id;
	}
	
	$.ajax({
		url: url,
		method: 'GET'
	}).done(function (data) {
		let lista = '<option>seleccione...</option>';
		for (let i = 0; i < data.length; i++) {
			lista += '<option value="' + data[i].id + '">' + data[i].nombre + '</option>';
		}
		$('#pais').html(lista);
	}).fail(function (jqXHR, textStatus, errorThrown) {
		console.error('Error:', textStatus, errorThrown);
	});
}

function cargarPaisesCategorias(id) {
	$('#categoria').html('<option>Cargando...</option>');
	let url = '/api/cargarCategoriasPaises';
	if (id) {
		url += '/' + id;
	}

	$.ajax({
		url: url,
		method: 'GET'
	}).done(function (data) {
		let lista = '<option>seleccione...</option>';
		for (let i = 0; i < data.length; i++) {
			lista += '<option value="' + data[i].id + '">' + data[i].nombre + '</option>';
		}
		$('#categoria').html(lista);
	}).fail(function (jqXHR, textStatus, errorThrown) {
		console.error('Error:', textStatus, errorThrown);
	});
}

