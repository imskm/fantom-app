<div class="accordian">
	<button class="accordian-button">
		<div class="accordian-title-wrapper">
			<h1 class="accordian-title">Acount Settings</h1>
			<h2 class="accordian-subtitle">Change your account password</h2>
		</div>
		<div class="accordian-icon">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"/></svg>
		</div>
	</button>
	<div id="app" class="accordian-body">
		<form @submit.prevent="updateAccountPassword" action="/api/setting/change-password" method="post">
			<div class="form-controls-row">
				<label for="old_password">Old Password</label>
				<input v-model="accountSetting.old_password" id="old_password" type="password" name="old_password" placeholder="********">
				<p class="form-error" v-if="errors.old_password">{{ errors.old_password }}</p>
			</div>
			<div class="form-controls-row">
				<label for="password">New Password</label>
				<input v-model="accountSetting.password" id="password" type="password" name="password" placeholder="********">
				<p class="form-error" v-if="errors.password">{{ errors.password }}</p>
			</div>
			<div class="form-controls-row">
				<label for="confirm">Confirm Password</label>
				<input v-model="accountSetting.confirm" id="confirm" type="password" name="confirm" placeholder="********">
				<p class="form-error" v-if="errors.confirm">{{ errors.confirm }}</p>
			</div>
			<div class="form-controls-row">
				<button type="submit" class="btn btn-secondary">Save</button>
			</div>
		</form>
	</div>
</div>
	