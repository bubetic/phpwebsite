<?php
	require_once 'utils.php';
	if(isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) {
		if(isAuthenticated() && validateSessionClient()) {
			session_destroy();
			echo 0;
		}
		else {
			echo 1;
		}
	}
	else {
		echo 1;
	}