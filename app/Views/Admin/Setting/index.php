<?php $this->use('templates/admin.php', ['title' => 'Settings']) ?>

<div class="section dashboard-section">
	<div class="container">
		<div class="page-header">
			<h1 class="text-black">Settings</h1>
		</div>

		<?php include VIEW_PATH . '/partials/_message.php' ?>

		<div class="settings-wrapper">

			<div class="accordians">
				<?php include VIEW_PATH . '/partials/admin/_account-password-setting.php' ?>
				<?php include VIEW_PATH . '/partials/admin/_profile-picture-setting.php' ?>
				<?php include VIEW_PATH . '/partials/admin/_personal-info.php' ?>
			</div>

		</div>

	</div>
</div>

<?php $this->section("scripts") ?>

<script>
const accountSettingModel = {
	old_password: "",
	password: "",
	confirm: "",
};

let userModel = {
	first_name: "<?= e($user->first_name) ?>",
	last_name: "<?= e($user->last_name) ?>",
};

const app = new Vue({
	el: "#app",
	data: {
		accountSetting: accountSettingModel,
		isProcessing: false,
		image_url: null,
		errors: {},
	},

	methods: {
		updateAccountPassword() {
			this.isProcessing = true;
			const data = prepareFormForPost(this.accountSetting);
			const url = "/api/setting/change-password";
			AxiosRequest.post(url, data, {
				success: (res) => {
					alert("Password changed successfully!");
					this.resetForm();
				},
				error: (res) => {
					console.log("OK---", res);
					this.errors = res.errors;
				},
				except: (error) => {
					console.error(error);
				},
				finally: () => {
					this.isProcessing = false;
				},
			});
		},

	},
});

const profile = new Vue({
	el: "#profile",
	data: {
		isProcessing: false,
		image_url: null,
		errors: {},
	},

	methods: {

		updateProfilePicture() {
			if (!this.image_url) {
				return;
			}

			const url = `/api/setting/upload-image`;
				  form = new FormData();
			form.append("photos[]", this.image_url);

			AxiosRequest.post(url, form, {
				success: (response) => {
					alert("Image uploaded successfully");
					window.location.reload();
				},
				error: (response) => { 
					this.errors = response.errors;
				},
				except: error => {
					alert("Something bad happened!");
				},
			});
		},

		selectFile(event) {
			this.image_url = event.target.files[0];
		},

		resetForm() {
			this.accountSetting = emptyObjectProperty(this.accountSetting);
		}
	},
});

const personalDetail = new Vue({
	el: "#personalDetail",
	data: {
		user: userModel,
		isProcessing: false,
		errors: {},
	},

	methods: {

		updateUserInfo() {
			const data = prepareFormForPost(this.user);
			const url = `/api/setting/update-personal`;

			AxiosRequest.post(url, data, {
				success: (res) => {
					alert("Personal Info update successfully!");
					this.resetForm();
				},
				error: (res) => {
					console.log("OK---", res);
					this.errors = res.errors;
				},
				except: (error) => {
					console.error(error);
				},
				finally: () => {
					this.isProcessing = false;
				},
			});
		},
	},
});
</script>

<?php $this->endSection() ?>