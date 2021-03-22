<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!doctype html>
<html lang="en" class="h-100">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Portal SMG</title>
	<link rel="shortcut icon" type="image/jpg" href="<?= base_url('assets/dist/') . 'img/favicon.png' ?>">

	<!-- Bootstrap core CSS -->
	<link href="<?= base_url('assets/dist/') . 'css/bootstrap.min.css' ?>" rel="stylesheet">
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?= base_url('assets/plugins/') . 'fontawesome-free/css/all.min.css' ?>">
	<!-- ApexChart -->
	<link href="<?= base_url('assets/plugins/') . 'apexcharts/dist/apexcharts.css' ?>" rel="stylesheet">
	<!-- Datepicker -->
	<link href="<?= base_url('assets/plugins/') . 'bootstrap-datepicker/css/bootstrap-datepicker.min.css' ?>" rel="stylesheet">
	<!-- BS Selectpicker -->
	<link href="<?= base_url('assets/plugins/') . 'bootstrap-select/css/bootstrap-select.min.css' ?>" rel="stylesheet">
	<!-- Sweetalert2 -->
	<link href="<?= base_url('assets/plugins/') . 'sweetalert2/sweetalert2.min.css' ?>" rel="stylesheet">
	<!-- Datatables -->
	<link href="<?= base_url('assets/plugins/') . 'datatables-bs4/css/dataTables.bootstrap4.min.css' ?>" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="<?= base_url('assets/dist/') . 'css/style/style.css' ?>" rel="stylesheet">


	<!-- JQuery -->
	<script src="<?= base_url('assets/plugins/') . 'jquery/jquery-3.5.1.min.js' ?>"></script>
	<!-- Popper -->
	<script src="<?= base_url('assets/plugins/') . 'popper/umd/popper.min.js' ?>"></script>
	<!-- ApexChart -->
	<script src="<?= base_url('assets/dist/') . 'js/bootstrap.min.js' ?>"></script>
	<!-- Bootstrap4 -->
	<script src="<?= base_url('assets/plugins/') . 'apexcharts/dist/apexcharts.min.js' ?>"></script>
	<!-- Sweetalert2 -->
	<script src="<?= base_url('assets/plugins/') . 'sweetalert2/sweetalert2.min.js' ?>"></script>
	<!-- Datepicker -->
	<script src="<?= base_url('assets/plugins/') . 'bootstrap-datepicker/js/bootstrap-datepicker.min.js' ?>"></script>
	<!-- BS Selectpicker -->
	<script src="<?= base_url('assets/plugins/') . 'bootstrap-select/js/bootstrap-select.min.js' ?>"></script>
	<!-- Datatables -->
	<script src="<?= base_url('assets/plugins/') . 'datatables/jquery.dataTables.min.js' ?>"></script>
	<script src="<?= base_url('assets/plugins/') . 'datatables-bs4/js/dataTables.bootstrap4.min.js' ?>"></script>
	

	<script>
		$(document).ready(function() {
			$(".preloader").fadeOut("slow");

			$('.datepicker').datepicker({
				format: 'dd/mm/yyyy',
				autoclose: true,
				todayHighlight: true,
				endDate: '0d'
			});

			$('.selectpicker').selectpicker();
		});
	</script>

</head>

<body class="d-flex flex-column h-100">

	<?php if ($this->uri->segment(1) != '') : ?>
		<div class="preloader">
			<div class="loading">
				<div class="spinner-border" role="status">
					<span class="sr-only">Loading...</span>
				</div>
			</div>

			<p class="text-loading mt-3">
				<strong>Please Wait</strong>
			</p>
		</div>
	<?php endif; ?>
