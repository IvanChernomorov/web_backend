<?php

define("BASE_DIR", __DIR__ . DIRECTORY_SEPARATOR);

require_once(BASE_DIR . "src/Requester.php");
require_once(BASE_DIR . "src/UserDB.php");

$dbUser = new UserDB('localhost', 'u47556', '2195834', 'u47556');
$dbRequester = new Requester($dbUser);

if (
	empty($_SERVER['PHP_AUTH_USER']) ||
	empty($_SERVER['PHP_AUTH_PW']) ||
	!$dbRequester->adminAuth($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])
) {
	header('HTTP/1.1 401 Unanthorized');
	header('WWW-Authenticate: Basic realm="Test Authentication System"');
	echo '<h1>401 Требуется авторизация</h1>';
	echo "<p>Перейти на <a href='index.php'>главную</a> страницу!</p>";
	exit();
}

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if (!empty($action))
{
	if($action === 'delete' && !empty($id)) {
		$dbRequester->deleteUser($id);
	}
	if($action == 'change'){
		$db = new PDO("mysql:host=$dbServerName;dbname=$dbName", $dbUser, $dbPassword);
		$success = false;
		try {
			$sql =
				"SELECT * FROM user_authentication
				WHERE id = :id";
		$stmt = $db->prepare($sql);
		$stmt->execute(array('id' => $id));
		$login = $stmt->fetch();
		} catch (PDOException $e) {
			print('Error : ' . $e->getMessage());
			exit();
		}
			$_SESSION['login'] = $login;
			$_SESSION['loginid'] = $id;
		header("Location: index.php");
		exit();
}

require_once("adminlog.php");
