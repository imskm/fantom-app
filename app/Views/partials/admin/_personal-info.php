<div class="accordian">
	<button class="accordian-button">
		<div class="accordian-title-wrapper">
			<h1 class="accordian-title">Personal Details</h1>
			<h2 class="accordian-subtitle">Change your personal details</h2>
		</div>
		<div class="accordian-icon">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"/></svg>
		</div>
	</button>
	<div id="personalDetail" class="accordian-body">
		<form @submit.prevent="updateUserInfo" action="/api/setting/change-password" method="post">
			<div class="form-controls-row">
				<label for="first_name">First name</label>
				<input v-model="user.first_name" id="first_name" type="text" name="first_name" placeholder="********">
				<p class="form-error" v-if="errors.first_name">{{ errors.first_name }}</p>
			</div>
			<div class="form-controls-row">
				<label for="last_name">Last name</label>
				<input v-model="user.last_name" id="last_name" type="text" name="last_name" placeholder="********">
				<p class="form-error" v-if="errors.last_name">{{ errors.last_name }}</p>
			</div>
			<div class="form-controls-row">
				<label for="phone">Phone</label>
				<input v-model="user.phone" id="phone" type="text" name="phone" placeholder="********">
				<p class="form-error" v-if="errors.phone">{{ errors.phone }}</p>
			</div>
			<div class="form-controls-row">
				<button type="submit" class="btn btn-secondary">Save</button>
			</div>
		</form>
	</div>
</div>
	