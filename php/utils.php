<?php
	require_once 'config.php';

	// --- Centralized secure session configuration ---
	if(session_status() !== PHP_SESSION_ACTIVE) {
		$useHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
		// Set cookie params before starting session
		$cookieParams = [
			'lifetime' => 0,
			'path' => '/',
			'domain' => '',
			'secure' => $useHttps,
			'httponly' => true,
			'samesite' => 'Lax'
		];
		if(function_exists('session_set_cookie_params')) {
			session_set_cookie_params($cookieParams);
		}
		// Start session after configuring cookie params
		session_start();
	}

	//use PHPMailer\PHPMailer\PHPMailer;
	//use PHPMailer\PHPMailer\Exception;

	//require 'PHPMailer-master/src/Exception.php';
	//require 'PHPMailer-master/src/PHPMailer.php';
	//require 'PHPMailer-master/src/SMTP.php';

	function connect() {
		$C = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
		if($C->connect_error) {
			return false;
		}
		return $C;
	}



	function sqlSelect($C, $query, $format = false, ...$vars) {
		$stmt = $C->prepare($query);
		if($format) {
			$stmt->bind_param($format, ...$vars);
		}
		if($stmt->execute()) {
			$res = $stmt->get_result();
			$stmt->close();
			return $res;
		}
		$stmt->close();
		return false;
	}

	function sqlInsert($C, $query, $format = false, ...$vars) {
		$stmt = $C->prepare($query);
		if($format) {
			$stmt->bind_param($format, ...$vars);
		}
		if($stmt->execute()) {
			$id = $stmt->insert_id;
			$stmt->close();
			return $id;
		}
		$stmt->close();
		return -1;
	}

	function sqlUpdate($C, $query, $format = false, ...$vars) {
		$stmt = $C->prepare($query);
		if($format) {
			$stmt->bind_param($format, ...$vars);
		}
		if($stmt->execute()) {
			$stmt->close();
			return true;
		}
		$stmt->close();
		return false;
	}


	function createToken() {
		$seed = urlSafeEncode(random_bytes(8));
		$t = time();
		$hash = urlSafeEncode(hash_hmac('sha256', session_id() . $seed . $t, CSRF_TOKEN_SECRET, true));
		return urlSafeEncode($hash . '|' . $seed . '|' . $t);
	}

	function validateToken($token) {
		$parts = explode('|', urlSafeDecode($token));
		if(count($parts) === 3) {
			$hash = hash_hmac('sha256', session_id() . $parts[1] . $parts[2], CSRF_TOKEN_SECRET, true);
			if(hash_equals($hash, urlSafeDecode($parts[0]))) {
				return true;
			}
		}
		return false;
	}

	function urlSafeEncode($m) {
		return rtrim(strtr(base64_encode($m), '+/', '-_'), '=');
	}
	function urlSafeDecode($m) {
		return base64_decode(strtr($m, '-_', '+/'));
	}

	// --- Session integrity helpers ---
	function validateSessionClient() {
		$currIp = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
		$currUa = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		if(!isset($_SESSION['ip']) || !isset($_SESSION['ua'])) {
			return false;
		}
		if($_SESSION['ip'] !== $currIp) {
			return false;
		}
		if($_SESSION['ua'] !== $currUa) {
			return false;
		}
		return true;
	}

	function isAuthenticated() {
		return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['userID']);
	}



	// function sendEmail($to, $toName, $subj, $msg) {
	// 	$mail = new PHPMailer(true);
	// 	try {
	//     //Server settings
	//     $mail->isSMTP();
	//     $mail->Host       = SMTP_HOST;
	//     $mail->SMTPAuth   = true;
	//     $mail->Username   = SMTP_USERNAME;
	//     $mail->Password   = SMTP_PASSWORD;
	//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	//     $mail->Port       = SMTP_PORT;

	//     //Recipients
	//     $mail->setFrom(SMTP_FROM, SMTP_FROM_NAME);
	//     $mail->addAddress($to, $toName);

	//     // Content
	//     $mail->isHTML(true);
	//     $mail->Subject = $subj;
	//     $mail->Body    = $msg;

	//     $mail->send();
	//     return true;
	// 	} 
	// 	catch(Exception $e) {
	// 		return false;
	// 	}
	}