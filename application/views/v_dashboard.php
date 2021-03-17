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
						<div class="row">
							<div class="col-md-3">
								<img src="<?= base_url('assets/dist/') . 'img/img-icon.png' ?>" style="height: 60px; width: 60px;">
							</div>
							<div class="col-md">
								<h5 class="card-title">Outstanding</h5>
								<p class="card-text my-2" style="font-size: 20px;">Rp. <?= number_format(!isset($performance) ? 0 : $performance / 1000000000, 2) ?> M</p>
								<p class="card-subtitle mb-2 text-muted">Posisi <?= !isset($posisi) ? '-' : $posisi ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="card mb-3">
					<div class="card-body p-2">
						<div class="row">
							<div class="col-md-3">
								<img src="<?= base_url('assets/dist/') . 'img/img-icon.png' ?>" style="height: 60px; width: 60px;">
							</div>
							<div class="col-md">
								<h5 class="card-title">Realisasi Pencairan</h5>
								<p class="card-text my-2" style="font-size: 20px;">Rp. <?= number_format(!isset($pencairan) ? 0 : $pencairan / 1000000000, 2) ?> M</p>
								<p class="card-subtitle mb-2 text-muted">Posisi <?= !isset($posisi) ? '-' : $posisi ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="card mb-3">
					<div class="card-body p-2">
						<div class="row">
							<div class="col-md-3">
								<img src="<?= base_url('assets/dist/') . 'img/img-icon.png' ?>" style="height: 60px; width: 60px;">
							</div>
							<div class="col-md">
								<h5 class="card-title">NPF</h5>
								<p class="card-text my-2" style="font-size: 20px;">Rp. <?= number_format(rand() / 1000000, 2) ?> Jt</p>
								<p class="card-subtitle mb-2 text-muted">Posisi 31 Feb 2021</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-sm-6">
				<div class="card mb-3">
					<div class="card-body p-2">
						<div class="row">
							<div class="col-md-3">
								<img src="<?= base_url('assets/dist/') . 'img/img-icon.png' ?>" style="height: 60px; width: 60px;">
							</div>
							<div class="col-md">
								<h5 class="card-title">Dana</h5>
								<p class="card-text my-2" style="font-size: 20px;">Rp. <?= number_format(rand() / 1000000, 2) ?> Jt</p>
								<p class="card-subtitle mb-2 text-muted">Posisi 31 Feb 2021</p>
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
						<div id="chart"></div>
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

	var labelFormatter = function(value) {
		var nf = new Intl.NumberFormat();
		var val = Math.abs(value);
		if (val >= 1000000000) {
			val = nf.format((val / 1000000000).toFixed(2)) + " M";
		}
		return val;
	};

	var options = {
		series: [{
			name: 'Outstanding',
			type: 'column',
			data: <?= $outstanding; ?>
		}, {
			name: 'Realisasi Pencairan',
			type: 'line',
			data: <?= $plafond; ?>
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
		labels: <?= $labels; ?>,
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

	chart.render();
</script>

<?php $this->load->view('template/footer'); ?>
