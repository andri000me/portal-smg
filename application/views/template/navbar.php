<header>
	<!-- Fixed navbar -->
	<nav class="navbar navbar-expand-md" style="background-color: #1ca39d;">
		<a class="navbar-brand" href="#">
			<img src="<?= base_url('assets/dist/') . 'img/logo-bsi.png' ?>" alt="logo-bsi" style="height: 45px; width: 180px;">
		</a>

		<?php if (isset($_SESSION['is_login'])) : ?>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
						<span><?= $_SESSION['nm_user']; ?> <i class="fa fa-user-circle ml-1"></i></span>
					</a>
					<div class="dropdown-menu" id="dropdown-user" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="#">Profile</a>
						<a class="dropdown-item" href="<?= site_url('logout') ?>">Log Out</a>
					</div>
				</li>
			</ul>
		<?php endif; ?>
	</nav>
</header>

<?php if(isset($_SESSION['is_login'])) : ?>
<div class="container-fluid px-0">
	<nav class="navbar navbar-expand-lg navbar-light bg-light px-5">
		<a class="navbar-brand" href="<?= site_url('dashboard') ?>">Dashboard</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="../e-filing" target="_blank">Linkage</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Non-Linkage</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Portofolio & QA
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="<?= site_url('performance') ?>">Daily Performance</a>
						<a class="dropdown-item" href="#">Downgrade</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="<?= site_url('dbs') ?>">DBS Performance</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>
</div>
<?php endif; ?>
