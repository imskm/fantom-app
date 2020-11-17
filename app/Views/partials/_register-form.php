<form action="/auth/register/store" method="post">
  
  <?php include VIEW_PATH . '/partials/_message.php' ?>

  <div class="field">
    <lable class="label">Name</lable>
    <div class="columns">
      <div class="column">
        <div class="control">
          <input class="input" type="text" maxlength="32" placeholder="First name" name="first_name" autofocus="">
        </div>
      </div>
      <div class="column">
        <div class="control">
          <input class="input" type="text" maxlength="32" placeholder="Last name" name="last_name">
        </div>
      </div>
    </div>
  </div>

  <div class="field">
    <lable class="label">Email</lable>
    <p class="control has-icons-left">
      <input class="input" type="email" placeholder="e.g. you@fantom.com" name="email">
      <span class="icon is-small is-left">
        <i class="fas fa-envelope"></i>
      </span>
    </p>
  </div>
  <div class="field">
    <lable class="label">Password</lable>
    <div class="columns">
      <div class="column">
        <div class="control">
          <input class="input" type="password" placeholder="Password" name="password">
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
      <button class="button is-success">Create account</button>
    </p>
  </div>
</form>
