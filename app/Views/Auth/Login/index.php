<?php $this->use('templates/base-login.php', ['title' => 'Login']) ?>

<div class="login-container">
	<div class="login-plate">
		<div class="login-head">
			<h1 class="login-title">Login</h1>
		</div>
		<?php include VIEW_PATH . '/partials/_message.php' ?>
		<?php include VIEW_PATH . '/partials/_login-form.php' ?>
	</div>
</div>