<!DOCTYPE html>                                                                                                                                                             
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <title>Recover your account</title>
</head> 
<body>  
    <h1>Recover your <?= e(\App\Config::get('site_name')) ?> account</h1>
    <p>Dear <?= e($full_name) ?>,</p>
    <p>We have received password reset request for your <?= e(\App\Config::get('site_name')) ?> account, if it was you then reset your password by clicking on the link below or if it was not you then ignore this email.</p>
    <p>
    	<a href="<?= \App\Config::get('site_url') ?>/auth/reset-password/index?token=<?= e($token) ?>">
    		<?= \App\Config::get('site_url') ?>/auth/reset-password/index?token=<?= e($token) ?>
    	</a>
    </p>
</body> 
</html>
