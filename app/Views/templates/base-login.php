<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#FF0042">
<title><?= $title ?> | <?= \App\Config::get('company_name') ?></title>

<link rel="stylesheet" href="/assets/css/mrflexible.css">
<link rel="stylesheet" href="/assets/css/app.css?v=1.0.0">
<link href="https://unpkg.com/ionicons@4.3.0/dist/css/ionicons.min.css" rel="stylesheet">
<link rel="icon" type="image/png" size="16x16" href="/assets/img/favicon.png">

</head>
<body>

	<?= $this->content() ?>

	<script src="/assets/js/mrflexible.js"></script>
</body>
</html>