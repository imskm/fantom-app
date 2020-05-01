<form action="/user/setting/change-password" method="post">
  <div class="field">
    <lable for="old_password" class="label">Old password</lable>
    <p class="control has-icons-left">
      <input id="old_password" class="input" type="password" name="old_password">
      <span class="icon is-small is-left">
        <i class="fas fa-lock"></i>
      </span>
    </p>
  </div>
  <div class="field">
    <lable for="password" class="label">New Password</lable>
    <div class="columns">
      <div class="column">
        <div class="control">
          <input id="password" class="input" type="password" placeholder="Password" name="password">
        </div>
      </div>
      <div class="column">
        <div class="control">
          <input class="input" type="password" placeholder="Confirm" name="confirm">
        </div>
      </div>
    </div>
  </div>
  <div class="field">
    <p class="control">
      <button class="button is-success">Change</button>
    </p>
  </div>
</form>
