<?php
$this->load->view('template/header');
$this->load->view('template/navbar');
?>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
	<div class="container-fluid px-5">

		<div class="row">
			<div class="col-md-12 pt-3">
				<button class="btn btn-sm btn-success float-right mx-1" id="btn_filter">Show Filter</button>
				<?php if ($_SESSION['lv_user'] == 'admin') : ?>
					<button class="btn btn-sm btn-warning float-right mx-1" id="btn_upload">Upload File</button>
				<?php endif; ?>
				<h3><?= $title; ?></h3>
			</div>
			<div class="col-md-12 pt-3" id="card_filter" style="display: none;">
				<div class="card">
					<div class="card-body pb-0">
						<div class="col-md-8">
							<form id="form_filter" autocomplete="off">
								<div class="form-group row">
									<label class="col-sm-3 col-md-2 col-form-label">Nama File</label>
									<div class="col-sm-8 col-md-6">
										<input type="text" class="form-control" name="filename" id="filename">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-md-2 col-form-label">Module</label>
									<div class="col-sm-8 col-md-5">
										<select class="form-control selectpicker" id="filter_module" name="filter_module">
											<option value="">-- Please Select --</option>
											<option value="Performance">Performance</option>
											<option value="Reporting">Reporting</option>
											<option value="Realisasi Pencairan">Realisasi Pencairan</option>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-md-2 col-form-label">Tanggal Data</label>
									<div class="col-sm-8 col-md-5">
										<div class="input-group flex-nowrap">
											<input type="text" class="form-control datepicker" name="tgl_awal" id="tgl_awal" style="padding: 6px 12px;">
											<div class="input-group-prepend">
												<span class="input-group-text" id="addon-wrapping">to</span>
											</div>
											<input type="text" class="form-control datepicker" name="tgl_akhir" id="tgl_akhir" style="padding: 6px 12px;">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-md-2 col-form-label">&nbsp;</label>
									<div class="col-auto">
										<span class="btn btn-primary" id="btn_search">Search</span>
										<span class="btn btn-warning" id="btn_reset">Reset</span>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12 pt-3">
				<div class="card">
					<div class="card-body">
						<table class="display nowrap table table-bordered table-hover" id="table" width="100%">
							<thead>
								<tr>
									<th class="text-center" style="width: 30px;">#</th>
									<th>Module</th>
									<th>File Name</th>
									<th>Tgl Data</th>
									<th>File Size</th>
									<th>Upload Time</th>
									<th class="text-center">Opsi</th>
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

<!-- Modal -->
<form id="form_upload" autocomplete="off">
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Form Upload File</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label class="col-sm-3 col-md-2 col-form-label">Tanggal Data</label>
						<div class="col-sm-5 col-md-3">
							<div class="input-group">
								<input type="text" class="form-control datepicker" name="tgl_data" id="tgl_data" style="padding: 6px 12px;">
								<div class="input-group-append">
									<span class="input-group-text" id="basic-addon2"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
							<small class="help-text" id="tgl_data-feedback"></small>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-md-2 col-form-label">Module</label>
						<div class="col-sm-6 col-md-4">
							<select class="form-control selectpicker" id="module" name="module">
								<option value="">-- Please Select --</option>
								<option>Performance</option>
								<option value="Reporting">Reporting</option>
								<option>Realisasi Pencairan</option>
							</select>
							<small class="help-text" id="module-feedback"></small>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-md-2 col-form-label">Upload File</label>
						<div class="col-sm-8 col-md-6">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="file_upload" name="file_upload">
								<label class="custom-file-label" for="file_upload">Choose file</label>
							</div>
							<small class="help-text" id="file_upload-feedback"></small>
						</div>
					</div>
					<div class="form-group row">
						<div class="offset-sm-3 offset-md-2 col-sm-8 col-md-6">
							<div class="progress">
								<div id="file-progress-bar" class="progress-bar"></div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn_upload">Upload</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	var uploaded = false;

	$('#btn_filter').on('click', function() {
		if ($(this).text().trim() == 'Show Filter') {
			$(this).text('Hide Filter');
			$('#card_filter').slideDown();
		} else {
			$(this).text('Show Filter');
			$('#card_filter').slideUp();
		}
	});

	$('#btn_upload').on('click', function() {
		reset_form();

		$('#exampleModal').modal('show');
		$('.progress').css('display', 'none');
	});

	$('#file_upload').on('change', function(evt) {
		var filename = $(this).val();
		// var ext = /(\.xlsx|\.xls|\.txt|\.csv)$/i;
		var ext = /(\.txt|\.csv)$/i;
		var ext_pdf = /(\.pdf)$/i;

		if (filename == undefined || filename == "") {
			$(this).next('.custom-file-label').html('No file chosen');
		} else {
			if ($('#module').val() == 'Reporting') {
				if (!ext_pdf.exec(filename)) {
					Swal.fire({
						title: 'Oops!',
						text: 'Format file upload tidak sesuai, file yang diizinkan hanya pdf',
						icon: 'warning',
						allowOutsideClick: false,
					});

					$(this).next('.custom-file-label').html('No file chosen');
				} else {
					uploaded = true;
					$(this).next('.custom-file-label').html(evt.target.files[0].name);
				}
			} else {
				if (!ext.exec(filename)) {
					Swal.fire({
						title: 'Oops!',
						text: 'Format file upload tidak sesuai, file yang diizinkan hanya txt/csv',
						icon: 'warning',
						allowOutsideClick: false,
					});

					$(this).next('.custom-file-label').html('No file chosen');
				} else {
					uploaded = true;
					$(this).next('.custom-file-label').html(evt.target.files[0].name);
				}
			}
		}
	});

	//datatables
	table = $('#table').DataTable({
		"processing": true, //Feature control the processing indicator.
		"serverSide": true, //Feature control DataTables' server-side processing mode.
		"ordering": false,
		"searching": false,
		"scrollX": true,

		// Load data for the table's content from an Ajax source
		"ajax": {
			"url": "<?= site_url('dbs/get_list') ?>",
			"type": "POST",
			"data": function(data) {
				data.filename = $('#filename').val();
				data.module = $('#filter_module').val();
				data.tgl_awal = $('#tgl_awal').val();
				data.tgl_akhir = $('#tgl_akhir').val();
			}
		},

		'columnDefs': [{
				"targets": 0,
				"className": "text-center",
			},
			{
				"targets": 1,
				"width": "15%"
			},
			{
				"targets": 3,
				"className": "text-center",
				"width": "10%"
			},
			{
				"targets": -3,
				"className": "text-center",
				"width": "10%"
			},
			{
				"targets": -2,
				"width": "10%"
			},
			{
				"targets": -1,
				"className": "text-center",
				"width": "10%"
			}
		],
	});

	$('#btn_search').click(function() { //button filter event click
		table.ajax.reload(); //just reload table
	});

	$('#btn_reset').click(function() { //button reset event click
		$('#form_filter')[0].reset();
		table.ajax.reload(); //just reload table
	});

	$("#form_upload").on('submit', function(evt) {
		evt.preventDefault();
		if (uploaded === true) $('.progress').removeAttr('style');

		$.ajax({
			xhr: function() {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress", function(element) {
					if (element.lengthComputable) {
						var percentComplete = ((element.loaded / element.total) * 100).toFixed(2);
						$("#file-progress-bar").width(percentComplete + '%');
						$("#file-progress-bar").html(percentComplete + '%');
					}
				}, false);
				return xhr;
			},
			url: "<?= site_url('dbs/upload_file') ?>",
			type: "POST",
			dataType: "JSON",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function() {
				$("#file-progress-bar").width('0%');
			},
			success: function(data) {
				if (data.status === true && uploaded === true) {
					// set delay time 2s if upload progress 100%
					setTimeout(function() {
						$('#exampleModal').modal('hide');
						// set sweetalert reload page after 2s
						Swal.fire({
							title: data.title,
							text: data.text,
							icon: data.icon,
							timer: 2000,
							showConfirmButton: false,
							allowOutsideClick: false,
						}).then((result) => {
							if (result.dismiss === Swal.DismissReason.timer) {
								location.reload();
							}
						})
					}, 2000);
				} else {
					$(".help-text").removeClass("text-danger").empty();
					for (var i = 0; i < data.inputerror.length; i++) {
						$("#" + data.inputerror[i] + "-feedback").addClass("text-danger").text(data.error[i]);
					}
				}
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	});
</script>

<script>
	function reset_form() {
		$('#form_upload')[0].reset();
		$(".help-text").removeClass("text-danger").empty();
	}

	function hapus_file(id) {
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Data yang dihapus tidak bisa dikembalikan kembali!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#d33",
			cancelButtonColor: "#3085d6",
			confirmButtonText: "Hapus",
			cancelButtonText: "Tidak",
			allowOutsideClick: false,
		}).then((result) => {
			if (result.value) {
				$(".preloader").fadeIn("slow");
				$("p.text-loading>strong").text('Mohon tunggu, permintaan sedang di proses');

				$.ajax({
					url: "<?= site_url('dbs/hapus_file/') ?>" + id,
					type: "GET",
					dataType: "JSON",
					success: function(response) {
						if (response.status === true) {
							Swal.fire({
								title: response.msg['title'],
								icon: response.msg['icon'],
								text: response.msg['text'],
								timer: 2000,
								showConfirmButton: false,
								allowOutsideClick: false,
							}).then((result) => {
								if (result.dismiss === Swal.DismissReason.timer) {
									location.reload();
								}
							});
						}

						$(".preloader").fadeOut("slow");
					}
				});
			}
		});
	}


	function update_posisi(id) {
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Update data posisi mungkin akan membutuhkan waktu beberapa menit",
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Lakukan",
			cancelButtonText: "Batal",
			allowOutsideClick: false,
		}).then((result) => {
			if (result.value) {
				$(".preloader").fadeIn("slow");
				$("p.text-loading>strong").text('Mohon tunggu, sedang update data posisi');

				$.ajax({
					url: "<?= site_url('dbs/update_posisi/') ?>" + id,
					type: "POST",
					dataType: "JSON",
					success: function(result) {
						if (result.status === true) {
							Swal.fire({
								title: result.msg['title'],
								icon: result.msg['icon'],
								text: result.msg['text'],
								timer: 1000,
								showConfirmButton: false,
								allowOutsideClick: false,
							}).then((result) => {
								if (result.dismiss === Swal.DismissReason.timer) {
									location.reload();
								}
							});
						}

						$(".preloader").fadeOut("slow");
						// $("p.text-loading>strong").text('Please Wait');
					},
					error: function(xhr, status, th) {
						console.log(xhr + " - " + status + " - " + th);
					}
				});
			}
		});
	}
</script>

<?php $this->load->view('template/footer'); ?>
