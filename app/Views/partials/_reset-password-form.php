<form action="/auth/reset-password/reset-password" method="post">
  <div class="field">
    <lable class="label">New Password</lable>
    <p class="control has-icons-left">
      <input type="hidden" name="token" value="<?= e($token) ?>">
      <input class="input" type="password" placeholder="********" name="new_password">
      <span class="icon is-small is-left">
        <i class="fas fa-lock"></i>
      </span>
    </p>
  </div>
  <div class="field">
    <lable class="label">Confirm Password</lable>
    <p class="control has-icons-left">
      <input class="input" type="password" placeholder="********" name="confirm_new_password">
      <span class="icon is-small is-left">
        <i class="fas fa-lock"></i>
      </span>
    </p>
  </div>
  <div class="field">
    <div class="control">
      <button type="submit" class="button is-success">Reset Password</button>
    </div>
  </div>
</form>
