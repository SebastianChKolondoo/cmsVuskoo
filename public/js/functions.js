$(document).ready(function () {

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

function showCities(data) {
	$.ajax({
		url: 'selectcity',
		method: 'POST',
		data: { departament: data, _token: $('input[name="_token"]').val() },
	}).done(function (data) {
		console.log();
		lista = '';
		for (i = 0; i < data.length;) {
			lista += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
			i++;
		}
		$('#city').html(lista);
	});
}

