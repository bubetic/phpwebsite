<?php 
	require_once 'php/utils.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf_token" content="<?php echo createToken(); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - Secure Site</title>
	<link rel="stylesheet" href="<?php echo dirname($_SERVER['PHP_SELF']) . '/style.css'; ?>" />
</head>
<body>
				<h1>Log In</h1>
</body>
</html>
