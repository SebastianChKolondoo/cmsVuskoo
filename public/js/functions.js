$(document).ready(function () {
	$('.tox-notifications-container').addClass('hidden');	

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

	$('.egresos').change(function () {
		total = 0;
		total += parseInt($('#visdomegr_arriendo').val());
		total += parseInt($('#visdomegr_servicios_publi').val());
		total += parseInt($('#visdomegr_transporte').val());
		total += parseInt($('#visdomegr_alimentacion').val());
		total += parseInt($('#visdomegr_salud').val());
		total += parseInt($('#visdomegr_gasto_individua').val());
		total += parseInt($('#visdomegr_administracion').val());
		total += parseInt($('#visdomegr_tarjetas_de_cre').val());
		total += parseInt($('#visdomegr_prestamos').val());
		$('#visdomegr_total_egresos').val(total);
	});

	$('#departament').change(function () {
		showCities($(this).val());
	});
	
	$('#comercio').change(function () {
		cargarPaisesComercio($(this).val());
	});
	
	$('#pais').change(function () {
		cargarPaisesCategorias($(this).val());
	});


	openChild();
	$('#btnItem').click(function () {
		openAllTabs();
	});
	
});

let collapseContainers = false;

function openAllTabs() {
	if (!collapseContainers) {
		$('.collapse').removeClass('show');
		collapseContainers = true;
	}
	else {
		$('.collapse').addClass('show');
		collapseContainers = false;
	}
}


function openChild() {
	let url = window.location;
	url = String(window.location);
	let stringUrl = url.split("#");
	if (stringUrl.length > 1) {
		$('#' + stringUrl[1]).addClass('show').focus();

	}
}

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

