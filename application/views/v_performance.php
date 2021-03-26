<?php
$this->load->view('template/header');
$this->load->view('template/navbar');
?>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
	<div class="container-fluid py-3 px-5">
		<div class="row">
			<div class="col-md-12">
				<h3><?= $title; ?></h3>
			</div>

			<div class="col-md-12 pt-3">
				<div class="card mb-3">
					<div class="card-body">
						<div class="col-md-8">
							<form id="form_filter" autocomplete="off">
								<div class="form-group row">
									<label class="col-sm-3 col-md-2 col-form-label">Tanggal Data</label>
									<div class="col-sm-8 col-md-5">
										<div class="input-group flex-nowrap">
											<input type="text" class="form-control datepicker" name="tgl_awal" id="tgl_awal" style="padding: 6px 12px;">
											<div class="input-group-prepend">
												<span class="input-group-text" id="addon-wrapping">vs</span>
											</div>
											<input type="text" class="form-control datepicker" name="tgl_akhir" id="tgl_akhir" style="padding: 6px 12px;">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="offset-sm-3 offset-md-2 col-sm-8 col-md-5">
										<button type="submit" class="btn btn-primary btn_search">
											Bandingkan
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12" id="card_nasional" style="display: none;">
				<div class="card mb-3">
					<div class="card-header">Nasional</div>
					<div class="card-body">
						<p class="font-weight-bold d-flex justify-content-end my-0">(dalam satuan Miliar)</p>
						<table class="nowrap table table-sm table-boreder table-hover" id="tbl_nasional">
							<thead>
								<tr>
									<th class="text-center align-middle" rowspan="2">Segment</th>
									<th class="text-center border-left" colspan="7" id="th_tgl_awal"></th>
									<th class="text-center border-left" colspan="7" id="th_tgl_akhir"></th>
									<th class="text-center border-left" colspan="7">Delta</th>
								</tr>
								<tr>
									<th class="border-left">OS</th>
									<th>Kol 1</th>
									<th class="text-center">%</th>
									<th>Kol 2</th>
									<th class="text-center">%</th>
									<th>NPF</th>
									<th class="text-center">%</th>
									<th class="border-left">OS</th>
									<th>Kol 1</th>
									<th class="text-center">%</th>
									<th>Kol 2</th>
									<th class="text-center">%</th>
									<th>NPF</th>
									<th class="text-center">%</th>
									<th class="border-left">OS</th>
									<th>Kol 1</th>
									<th class="text-center">%</th>
									<th>Kol 2</th>
									<th class="text-center">%</th>
									<th>NPF</th>
									<th class="text-center">%</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<script>
	$('#tbl_nasional').DataTable({
		'ordering': false,
		'info': false,
		'searching': false,
		'paging': false
	});

	$("#form_filter").on('submit', function(evt) {
		evt.preventDefault();
		$('.btn_search').attr('disabled', true).html('<i class="fa fa-pulse fa-spinner"></i> Loading');

		ajax_nasional();
	});

	function ajax_nasional() {
		$.ajax({
			url: "<?= site_url('performance/list_nasional') ?>",
			type: "POST",
			dataType: "JSON",
			data: new FormData($('#form_filter')[0]),
			contentType: false,
			cache: false,
			processData: false,
			success: function(respon) {
				var data = respon.data;
				var html = '';

				$('.btn_search').removeAttr('disabled').text('Bandingkan');

				if (respon.status === true) {
					$('#card_nasional').fadeIn('slow');
					$('#tbl_nasional_wrapper').css('overflow-x', 'auto');

					$('#th_tgl_awal').text($('#tgl_awal').val());
					$('#th_tgl_akhir').text($('#tgl_akhir').val());

					for (let i = 0; i < data.dt_tgl_awal.length; i++) {
						html += '<tr>';
						// tgl_awal
						for (let n = 1; n < data.dt_tgl_awal[i].length; n++) {
							if (n == 2) {
								html += '<td class="border-left">';
							} else {
								html += '<td>';
							}
							html += data.dt_tgl_awal[i][n].toLocaleString('en-US', {
								maximumFractionDigits: 2
							});
							html += '</td>';
						}
						// tgl_akhir
						for (let n = 2; n < data.dt_tgl_akhir[i].length; n++) {
							if (n == 2) {
								html += '<td class="border-left">';
							} else {
								html += '<td>';
							}
							html += data.dt_tgl_akhir[i][n].toLocaleString('en-US', {
								maximumFractionDigits: 2
							});
							html += '</td>';
						}
						// delta
						for (let n = 0; n < data.delta[i].length; n++) {
							if (data.delta[i][n] < 0) {
								if (n == 0) {
									html += '<td class="text-danger border-left">';
								} else {
									html += '<td class="text-danger">';
								}
								html += data.delta[i][n].toLocaleString('en-US', {
									maximumFractionDigits: 2
								});
								html += '</td>';
							} else {
								if (n == 0) {
									html += '<td class="border-left">';
								} else {
									html += '<td>';
								}
								html += data.delta[i][n].toLocaleString('en-US', {
									maximumFractionDigits: 2
								});
								html += '</td>';
							}
						}
						html += '</tr>';
					}

					html += '<tr>';
					for (let i = 0; i < data.total.length; i++) {
						// Total
						if (data.total[i] < 0) {
							if (i == 1 || i == 8 || i == 15) {
								html += '<td class="border-left text-danger">';
							} else {
								html += '<td class="text-danger">';
							}
							html += data.total[i].toLocaleString('en-US', {
								maximumFractionDigits: 2
							});
							html += '</td>';
						} else {
							if (i == 1 || i == 8 || i == 15) {
								html += '<td class="border-left">';
							} else {
								html += '<td>';
							}
							html += data.total[i].toLocaleString('en-US', {
								maximumFractionDigits: 2
							});
							html += '</td>';
						}
					}
					html += '</tr>';

					$('#tbl_nasional>tbody').html(html);
				} else {
					$('#form_filter')[0].reset();

					Swal.fire({
						title: 'Oops!',
						icon: 'warning',
						text: respon.msg
					});
				}
			},
			error: function() {
				Swal.fire({
					title: 'Kesalah',
					icon: 'danger',
					text: 'Telah terjadi kesalahan pada server'
				});
			}
		});
	}
</script>

<?php $this->load->view('template/footer'); ?>
