<div class="accordian">
	<button class="accordian-button">
		<div class="accordian-title-wrapper">
			<h1 class="accordian-title">Profile Picture Settings</h1>
			<h2 class="accordian-subtitle">Change your profile picture</h2>
		</div>
		<div class="accordian-icon">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"/></svg>
		</div>
	</button>
	<div class="accordian-body" id="profile">
		<form @submit.prevent="updateProfilePicture" action="" method="post" enctype="multipart/form-data">
			<div class="form-controls-row">
				<img src="<?= $user->image_url ?>" alt="" class="avatar-xlarge-square">
			</div>
			<div class="form-controls-row">
				<label for="photo">Your Photo</label>
				<input @change="selectFile" type="file" name="file[]" required>
				<p v-if="errors.photos" class="form-error">{{ errors.photos }}</p>
			</div>
			<div class="form-controls-row">
				<button type="submit" class="btn btn-secondary">Save</button>
			</div>
		</form>
	</div>
</div>
