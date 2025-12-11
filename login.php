<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login - Secure Site</title>
</head>
<body>
	<h1>Log In</h1>
	<form id="loginForm">
		<div class="inputblock">
			<label for="email">Email</label>
			<input id="email" name="email" type="email" autocomplete="email" required placeholder="Enter your email" onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}"/>
		</div>
		<div class="inputblock">
			<label for="password">Password</label>
			<input id="password" name="password" type="password" autocomplete="current-password" required placeholder="Enter your password" onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}"/>
		</div>
	</form>
</body>
</html