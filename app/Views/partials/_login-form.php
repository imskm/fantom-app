<form action="/auth/login/authenticate" method="post">
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
    <div class="control">
      <div class="columns">
        <div class="column">
          <button class="button is-success">Login</button>
        </div>
        <div class="column">
          <p class="has-text-right">
            <a href="/auth/forgot-password">Forgotten password?</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</form>
