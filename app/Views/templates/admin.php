<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="theme-color" content="#f54d42">
		<title><?= $title ?> | Admin | <?= e(App\Config::get('site_name')) ?></title>
		<link href="/assets/css/main.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
		<link rel="icon" type="image/png" size="16x16" href="/assets/img/favicon.png">
	</head>
	<body>
		<div class="navbar navbar-dark">
			<div class="container fl-between">
				<div class="navbar-on-sm">
					<div class="navbar-logo bg-transparent">
						<img src="/assets/img/motivators-logo.webp" style="height: 40px" loading="lazy" alt="Motivators logo">
					</div>
					<div id="navbar-toggler" class="navbar-toggler">
						<span class="sticks"></span>
					</div>
				</div>

			<ul id="navmenu" class="navbar-menu">
				<li><a class="navbar-item" href="/admin/home/index">Dashboard</a></li>
				<li><a class="navbar-item" href="/admin/setting/index">Settings</a></li>
				<li><a class="navbar-item" href="/auth/login/logout">LOGOUT</a></li>

			</ul>
			</div>
		</div>	
		<?= $this->content() ?>
		<script src="/assets/js/mrflexible.js"></script>
		<script src="https://unpkg.com/axios@0.26.1/dist/axios.min.js"></script>
		<script src="/assets/js/scripts.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
		<?php $this->fetchSection('rte-scripts') ?>
		<?= $this->fetchSection("scripts") ?>
	</body>
</html>
