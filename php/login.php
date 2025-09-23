<?php
	require_once 'utils.php';

	// Ensure session is active for CSRF validation and session management
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
	
	if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) {
		// Normalize and validate inputs
		$email = strtolower(trim($_POST['email']));
		$password = $_POST['password'];
		if(!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
			usleep(250000);
			echo 1;
			exit;
		}

		$C = connect();
		if($C) {
			$hourAgo = time() - 60*60;
			$res = sqlSelect($C, 'SELECT users.id,password,verified,COUNT(loginattempts.id) FROM users LEFT JOIN loginattempts ON users.id = user AND timestamp>? WHERE email=? GROUP BY users.id', 'is', $hourAgo, $email);
			if($res && $res->num_rows === 1) {
				$user = $res->fetch_assoc();
				if($user['verified']) {
					if($user['COUNT(loginattempts.id)'] <= MAX_LOGIN_ATTEMPTS_PER_HOUR) {
						if(password_verify($password, $user['password'])) {
							// Successful login: regenerate session ID to prevent fixation
							session_regenerate_id(true);
							$_SESSION['loggedin'] = true;
							$_SESSION['userID'] = $user['id'];
							$_SESSION['ip'] = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
							$_SESSION['ua'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
							$_SESSION['last_login'] = time();

							// Rehash password if algorithm/options changed
							if(password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
								$newHash = password_hash($password, PASSWORD_DEFAULT);
								sqlUpdate($C, 'UPDATE users SET password=? WHERE id=?', 'si', $newHash, $user['id']);
							}

							// Clear failed attempts
							sqlUpdate($C, 'DELETE FROM loginattempts WHERE user=?', 'i', $user['id']);
							echo 0;
						}
						else {
							$id = sqlInsert($C, 'INSERT INTO loginattempts VALUES (NULL, ?, ?, ?)', 'isi', $user['id'], $_SERVER['REMOTE_ADDR'], time());
							usleep(250000);
							if($id !== -1) {
								echo 1;
							}
							else {
								echo 2;
							}
						}
					}
					else {
						echo 3;
					}
				}
				else {
					echo 4;
				}

				$res->free_result();
			}
			else {
				usleep(250000);
				echo 1;
			}
			$C->close();
		}
		else {
			echo 2;
		}
	}
	else {
		echo 1;
	}