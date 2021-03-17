<?php
$this->load->view('template/header');
$this->load->view('template/navbar');
?>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
	<div class="jumbotron jumbotron-fluid" style="background-color: white;">
		<div class="container">
			<div class="row d-flex justify-content-center">
				<div class="col-md-5 col-sm-12">
					<div class="card">
						<div class="card-header">
							Form Login
						</div>
						<div class="card-body">
							<?php if ($this->session->flashdata('msg') != '') : ?>
								<div class="alert alert-danger text-center" role="alert">
									<h5 class="alert-heading">Login failed!</h5>
									<span><?= $this->session->flashdata('msg'); ?></span>
								</div>
							<?php endif; ?>

							<form action="<?= site_url('auth/login') ?>" method="POST" autocomplete="off">
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Username</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="username" name="username" required autofocus>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Password</label>
									<div class="col-sm-8">
										<input type="password" class="form-control" id="password" name="password" required>
									</div>
								</div>
								<!-- <div class="form-group row">
									<div class="offset-3 col-sm-10">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" id="remember_me" name="remember_me">
											<label class="form-check-label" for="remember_me">
												Remember my login
											</label>
										</div>
									</div>
								</div> -->
								<div class="form-group row">
									<div class="offset-3 col-sm-10">
										<button type="submit" class="btn btn-primary">Log In</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php $this->load->view('template/footer'); ?>
