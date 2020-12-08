<?php $this->use('templates/base.php', ['title' => 'Forgot Password']) ?>

<section class="section">
	<div class="container">
		<div class="columns is-centered">
			<div class="column is-6">
				<div class="box">
					<h1 class="title">Forgot Password</h1>
					<hr>
					<?php include VIEW_PATH . '/partials/_message.php' ?>
					<div>
						<h2 class="subtitle has-text-success">Success!</h2>
						<p>We have sent a password reset link to email address. Please check the inbox and click on the link to reset your password.</p>
						<br>
						<div>
							<a href="/" class="button is-primary">Home</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
