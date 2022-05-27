<?php

define("BASE_DIR", __DIR__ . DIRECTORY_SEPARATOR);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if (session_start() && !empty($_SESSION['login'])) {
		if(isset($_GET['do'])&&$_GET['do'] == 'logout'){
			session_destroy();
		}
		header("Location: index.php");
		exit();
	}

	 elseif (!empty($_COOKIE['login-auth-error'])) {
		setcookie('login-auth-error', '', time() - 60 * 60 * 24);
		$lheader  = "Неверный логин и/или пароль";
	} else {
		$lheader = "Авторизуйтесь";
	}
	$message = array('login-error' => '', 'password-error' => '');
	if (!empty($_COOKIE['login-error'])) {
		setcookie('login-error', '', time() - 60 * 60 * 24);

		$message['login-error'] =
			"<div class='error'>{$_COOKIE['login-error']}</div>";
	}

	if (!empty($_COOKIE['password-error'])) {
		setcookie('password-error', '', time() - 60 * 60 * 24);
		$message['password-error'] =
			"<div class='error'>{$_COOKIE['password-error']}</div>";
	}
	require_once("loginpage.php");
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$dbServerName = 'localhost';
	$dbUser = "u47556";
	$dbPassword = "2195834";
	$dbName = $dbUser;
	$requestError = false;
	if (!empty($_POST)) {
		if (empty($_POST["login"])) {
			$errors['login'] = "Введите логин";
		}

		if (empty($_POST["password"])) {
			$errors['password'] = "Введите пароль";
		}
	} 


	if (isset($errors['login'])) {
		setcookie('login-error', $errors['login'], time() + 60 * 60 * 24);
	}
	if (isset($errors['password'])) {
		setcookie('password-error', $errors['password'], time() + 60 * 60 * 24);
	}


	if (isset($errors)) {
		header("Location: login.php");
		exit();
	}

	$userLogin = $_POST["login"];
	$userPassword = $_POST["password"];
	$db = new PDO("mysql:host=$dbServerName;dbname=$dbName", $dbUser, $dbPassword);
	$success = false;
	try {
		$sql =
			"SELECT * FROM user_authentication
			WHERE login = :login";
		$stmt = $db->prepare($sql);
		$stmt->execute(array('login' => $userLogin));
		$result = $stmt->fetch();

		if (!empty($result)) {
			$success = password_verify($userPassword, $result['password']);
			$userId = $result['id'];
		}
	} catch (PDOException $e) {
		print('Error : ' . $e->getMessage());
		exit();
	}

	if ($success) {
		session_start();
		$_SESSION['login'] = $userLogin;
		$_SESSION['loginid'] = $userId;
	} else {
		setcookie('login-auth-error', '1', time() + 60 * 60 * 24);
		header("Location: login.php");
		exit();
	}
	header("Location: index.php");
}
