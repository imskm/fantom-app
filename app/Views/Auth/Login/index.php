<?php $this->use('templates/base.php', ['title' => 'Login']) ?>

<section class="section">
	<div class="container">
		<div class="columns is-centered">
			<div class="column is-6">
				<div class="box">
					<h1 class="title">Login</h1>
					<hr>
					<?php include VIEW_PATH . '/partials/_message.php' ?>
					<?php include VIEW_PATH . '/partials/_login-form.php' ?>
				</div>
			</div>
		</div>
	</div>
</section>
