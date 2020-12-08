<form action="/auth/forgot-password/send-password-reset-link" method="post">
  <div class="field">
    <lable class="label">Email</lable>
    <p class="control has-icons-left">
      <input class="input" type="text" placeholder="e.g. you@fantom.com" name="email">
      <span class="icon is-small is-left">
        <i class="fas fa-envelope"></i>
      </span>
    </p>
    <p class="help">We will send link to reset password</p>
  </div>
  <div class="field">
    <div class="control">
      <div class="columns">
        <div class="column">
          <button class="button is-success">Send Email</button>
        </div>
      </div>
    </div>
  </div>
</form>
