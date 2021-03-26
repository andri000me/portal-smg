<?php
$this->load->view('template/header');
$this->load->view('template/navbar');
?>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
	<div class="container-fluid py-3 px-5">
		<!-- Card -->
		<div class="row">
			<div class="col-md-3 col-sm-6">
				<div class="card mb-3">
					<div class="card-body p-2">
						<div class="preloader_page text-center" style="padding: inherit;">
							<div class="loading_page">
								<div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</div>
						</div>

						<div class="row d-none">
							<div class="col-md-3">
								<img src="<?= base_url('assets/dist/') . 'img/img-icon.png' ?>" style="height: 60px; width: 60px;">
							</div>
							<div class="col-md">
								<h5 class="card-title">Outstanding</h5>
								<p id="ospokok" class="card-text my-2" style="font-size: 20px;"></p>
								<p class="card-subtitle mb-2 text-muted tgl_data"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="card mb-3">
					<div class="card-body p-2">
						<div class="preloader_page text-center" style="padding: inherit;">
							<div class="loading_page">
								<div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</div>
						</div>

						<div class="row d-none">
							<div class="col-md-3">
								<img src="<?= base_url('assets/dist/') . 'img/img-icon.png' ?>" style="height: 60px; width: 60px;">
							</div>
							<div class="col-md">
								<h5 class="card-title">Realisasi Pencairan</h5>
								<p id="plafond" class="card-text my-2" style="font-size: 20px;"></p>
								<p class="card-subtitle mb-2 text-muted tgl_data"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="card mb-3">
					<div class="card-body p-2">
						<div class="preloader_page text-center" style="padding: inherit;">
							<div class="loading_page">
								<div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</div>
						</div>

						<div class="row d-none">
							<div class="col-md-3">
								<img src="<?= base_url('assets/dist/') . 'img/img-icon.png' ?>" style="height: 60px; width: 60px;">
							</div>
							<div class="col-md">
								<h5 class="card-title">KOL 2</h5>
								<p id="kol2" class="card-text my-2" style="font-size: 20px;"></p>
								<p class="card-subtitle mb-2 text-muted tgl_data"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="card mb-3">
					<div class="card-body p-2">
						<div class="preloader_page text-center" style="padding: inherit;">
							<div class="loading_page">
								<div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</div>
						</div>

						<div class="row d-none">
							<div class="col-md-3">
								<img src="<?= base_url('assets/dist/') . 'img/img-icon.png' ?>" style="height: 60px; width: 60px;">
							</div>
							<div class="col-md">
								<h5 class="card-title">NPF</h5>
								<p id="npf" class="card-text my-2" style="font-size: 20px;"></p>
								<p class="card-subtitle mb-2 text-muted tgl_data"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ./Card -->

		<div class="row">
			<div class="col-md-12">
				<div class="card mb-3">
					<div class="card-body">
						<div class="preloader_page text-center" style="padding: inherit;">
							<div class="loading_page">
								<div class="spinner-border" role="status">
									<span class="sr-only">Loading...</span>
								</div>
							</div>
						</div>

						<div class="d-none" id="chart"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<script>
	/*
	var options = {
		series: [{
			name: 'Website Blog',
			type: 'column',
			data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
		}, {
			name: 'Social Media',
			type: 'line',
			data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
		}],
		chart: {
			height: 350,
			type: 'line',
			toolbar: {
				show: true,
				offsetX: -20,
				offsetY: 0,
				tools: {
					download: '<img src="<?= base_url('assets/dist/') . 'img/download-icon.png' ?>" width="25">',
					selection: false,
					zoom: false,
					zoomin: false,
					zoomout: false,
					pan: false,
					reset: false | '<img src="/static/icons/reset.png" width="20">',
					customIcons: []
				},
				export: {
					csv: {
						filename: "<?= 'performance_' . date('Ymd') ?>",
						columnDelimiter: '|',
						headerCategory: 'category',
						headerValue: 'value',
						dateFormatter(timestamp) {
							return new Date(timestamp).toLocaleDateString("en-US")
						}
					},
					png: {
						filename: "<?= 'performance_' . date('Ymd') . '_chart' ?>",
					}
				},
				autoSelected: 'zoom'
			},
		},
		stroke: {
			width: [0, 2]
		},
		title: {
			text: 'Traffic Sources'
		},
		dataLabels: {
			enabled: true,
			enabledOnSeries: [1]
		},
		labels: ['01 Jan 2021', '01 Feb 2021', '01 Mar 2021', '01 Apr 2021', '01 Mei 2021', '01 Jun 2021', '01 Jul 2021', '01 Aug 2021', '01 Sep 2021', '01 Oct 2021', '01 Nov 2021', '01 Dec 2021'],
		yaxis: [{
			title: {
				text: 'Website Blog',
			},

		}, {
			opposite: true,
			title: {
				text: 'Social Media'
			}
		}]
	};
	*/

	$(document).ready(function() {
		var labelFormatter = function(value) {
			var nf = new Intl.NumberFormat();
			var val = Math.abs(value);
			if (val >= 1000000000) {
				val = nf.format((val / 1000000000).toFixed(2)) + " M";
			}
			return val;
		};

		var options = {
			series: [],
			chart: {
				height: 350,
				type: 'line',
				toolbar: {
					show: true,
					offsetX: -20,
					offsetY: 0,
					tools: {
						download: '<img src="<?= base_url('assets/dist/') . 'img/download-icon.png' ?>" width="25">',
						selection: false,
						zoom: false,
						zoomin: false,
						zoomout: false,
						pan: false,
						reset: false | '<img src="/static/icons/reset.png" width="20">',
						customIcons: []
					},
					export: {
						csv: {
							filename: "<?= 'performance_' . date('Ymd') ?>",
							columnDelimiter: '|',
							headerCategory: 'category',
							headerValue: 'value',
							dateFormatter(timestamp) {
								return new Date(timestamp).toLocaleDateString("en-US")
							}
						},
						png: {
							filename: "<?= 'performance_' . date('Ymd') . '_chart' ?>",
						}
					},
					autoSelected: 'zoom'
				}
			},
			stroke: {
				width: [0, 2]
			},
			markers: {
				size: 4
			},
			title: {
				text: 'Performance Level'
			},
			// dataLabels: {
			// 	enabled: true,
			// 	enabledOnSeries: [1],
			// },
			yaxis: [{
				labels: {
					formatter: labelFormatter
				},
				title: {
					text: 'Outstanding',
				}
			}, {
				opposite: true,
				labels: {
					formatter: labelFormatter
				},
				title: {
					text: 'Realisasi Pencairan'
				}
			}]
		};

		var chart = new ApexCharts(document.querySelector("#chart"), options);

		$.getJSON('<?= site_url('dashboard/get_posisi') ?>', function(response) {
			$('.preloader_page').addClass('d-none');
			$('#chart, .row').removeClass('d-none');

			$('.tgl_data').text('Posisi ' + response.posisi['tgl_data']);
			$('#ospokok').text('Rp. ' + response.posisi['ospokok'] + ' M');
			$('#plafond').text('Rp. ' + response.posisi['plafond'] + ' M');
			$('#kol2').text('Rp. ' + response.posisi['kol2'] + ' M');
			$('#npf').text('Rp. ' + response.posisi['npf'] + ' M');

			chart.updateSeries(response.data);
			chart.updateOptions({
				labels: response.labels
			});
		});

		chart.render();
	});
</script>

<?php $this->load->view('template/footer'); ?>
