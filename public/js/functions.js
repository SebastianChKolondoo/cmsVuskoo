$(document).ready(function () {

	$('#additemmenu').on('click', () => {
		agregarItemSumenu();
	});

	const tiempoCupon = document.getElementById('TiempoCupon');
	const fechaExpiracionInicial = document.getElementById('field_fecha_inicial');
	const fechaExpiracionFinal = document.getElementById('field_fecha_final');

	function toggleFechaExpiracion() {
		if (tiempoCupon.value == '2') {
			fechaExpiracionInicial.classList.add('d-none');
			fechaExpiracionFinal.classList.add('d-none');
		} else {
			fechaExpiracionInicial.classList.remove('d-none');
			fechaExpiracionFinal.classList.remove('d-none');
		}
	}
	// Escucha el cambio en el select
	tiempoCupon.addEventListener('change', toggleFechaExpiracion);

	// Inicializa el estado correcto cuando la página se carga
	toggleFechaExpiracion();

	const tipoCupon = document.getElementById('tipoCupon');
	const codigoCupon = document.getElementById('field_codigo_cupon');

	function toggleTipoCupon() {
		if (tipoCupon.value == '1') {
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
		if ($(this).val() == 1) {
			$('#field_codigo_cupon').removeClass('d-none');
		}
		else {
			$('#field_codigo_cupon').addClass('d-none');
		}
	});

	/* $('#comercio').change(function () {
		cargarPaisesComercio($(this).val());
	}); */


});

let collapseContainers = false;

function cargarPaisesComercio(id) {

	$('#pais').html('<option>Cargando...</option>');
	let url = '/api/cargarPaises';
	let categoria = '';
	if (id) {
		url += '/' + id;
	}

	$.ajax({
		url: url,
		method: 'GET'
	}).done(function (data) {
		let lista = '<option>seleccione...</option>';
		for (let i = 0; i < data['paises'].length; i++) {
			lista += '<option value="' + data['paises'][i].id + '">' + data['paises'][i].nombre + '</option>';
		}
		$('#pais').html(lista).attr('disabled', false);
	}).fail(function (jqXHR, textStatus, errorThrown) {
		console.error('Error:', textStatus, errorThrown);
	});
}

function cargarCategoriaMarca(id) {

	$('#categoria').html('<option>aqui va...</option>');
	let url = '/api/cargarCategoriaMarca';
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
		$('#pais').html(lista).attr('disabled', false);
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
		$('#categoria').html(lista).attr('disabled', false);
	}).fail(function (jqXHR, textStatus, errorThrown) {
		console.error('Error:', textStatus, errorThrown);
	});
}

function agregarItemSumenu() {
	var elementos = document.querySelectorAll('.nuevoSubmenu');
	var cantidad = elementos.length;
	var nuevoItem = `
	<div class="row nuevoSubmenu">
		<div class="col-12 col-md-5">
			<div class="form-group">
				<label for="nombresubmenu_${cantidad}" class="form-label">Nombre SubMenú ${cantidad+1}</label>
				<input type="text" name="nombresubmenu_${cantidad}" class="form-control" required="required">
			</div>
		</div>
		<div class="col-12 col-md-5">
			<div class="form-group">
				<label for="urlsubmenu_${cantidad}" class="form-label">Url SubMenú ${cantidad+1}</label>
				<input type="text" name="urlsubmenu_${cantidad}" class="form-control" required="required">
			</div>
		</div>
		<div class="col-12 col-md-2">
			<div class="form-group">
				<label for="ordensubmenu_${cantidad}" class="form-label">Orden SubMenú ${cantidad+1}</label>
				<select type="text" value="${cantidad}" name="ordensubmenu_${cantidad}" class="form-control"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select>
			</div>
		</div>
	</div>`;
	$('#contenedorItemSubmenu').append(nuevoItem);


}

