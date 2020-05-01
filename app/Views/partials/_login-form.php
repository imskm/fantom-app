<form action="/auth/authenticate" method="post">
  <div class="field">
    <lable class="label">Email</lable>
    <p class="control has-icons-left">
      <input class="input" type="text" placeholder="e.g. you@fantom.com" name="email">
      <span class="icon is-small is-left">
        <i class="fas fa-envelope"></i>
      </span>
    </p>
  </div>
  <div class="field">
    <lable class="label">Password</lable>
    <p class="control has-icons-left">
      <input class="input" type="password" placeholder="Password" name="password">
      <span class="icon is-small is-left">
        <i class="fas fa-lock"></i>
      </span>
    </p>
  </div>
  <div class="field">
    <p class="control">
      <button class="button is-success">Login</button>
    </p>
  </div>
</form>
