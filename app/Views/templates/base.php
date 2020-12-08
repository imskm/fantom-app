<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="author" content="Shek Muktar">
<meta name="keywords" content="framework, mvc, php-framework, web-application">
<meta name="description" content="Fantom php web app">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?> | Fantom</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
<nav class="navbar is-white" role="navigation" aria-label="main navigation">
  <div class="container">
  	<div class="navbar-brand">
    <a class="navbar-item" href="https://bulma.io">
      <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
    </a>

    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">

    <div class="navbar-end">
      <a href="/" class="navbar-item">Home</a>
      <?php if (App\Support\Authentication\Auth::check()): ?>
        <div class="navbar-item has-dropdown is-hoverable">
          <a href="/user/profile" class="navbar-link">
            <strong><?= App\Support\Authentication\Auth::user()->first_name ?></strong>
          </a>
          
          <div class="navbar-dropdown is-right">
            <a href="/user/setting" class="navbar-item">
              <span class="icon is-medium">
                <i class="fas fa-cog"></i>
              </span>
              Settings
            </a>
            <hr class="navbar-divider">
            <a href="/auth/login/logout" class="navbar-item">
              <span class="icon is-medium">
                <i class="fas fa-sign-out-alt"></i>
              </span>
              Logout
            </a>
          </div>
          
        </div>
      <?php else: ?>
        <a href="/auth/login" class="navbar-item">Login</a>
        <div class="navbar-item">
          <div class="buttons">
            <a href="/auth/register" class="button is-primary">
              <strong>Sign up</strong>
            </a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
  </div>
</nav>

<div class="has-background-light">
<?php $this->content() ?>
</div>

<?php $this->fetchSection('test-section') ?>
</body>
</html>
