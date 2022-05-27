<?php

define("BASE_DIR", __DIR__ . DIRECTORY_SEPARATOR);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$flogin = '';
	if (!empty($_COOKIE['save'])) {
		setcookie("save", '', time() - 60 * 60 * 24);
		setcookie("login", '', time() - 60 * 60 * 24);
		setcookie("password", '', time() - 60 * 60 * 24);
		$fheader = "<p>Ваши данные сохранены!<p>";
		$flogin = "<p>Ваш логин:</p>" . $_COOKIE['login'] . "<p>Ваш пароль: </p>" . $_COOKIE['password'] . "<p><a href = 'login.php'>Войти</a></p>";
	} elseif (!empty($_COOKIE['update'])) {
		setcookie("update", '', time() - 60 * 60 * 24);
		$fheader = "<p>Ваши данные обновлены!<p>";
	} else {
		$fheader = "<p>Заполните данные!<p>";
	}
	$message = array();
	checkCookies('name', $message);
	checkCookies('email', $message);
	checkCookies('year', $message);
	checkCookies('gender', $message);
	checkCookies('numlimbs', $message);
	checkCookies('super-powers', $message);
	checkCookies('biography', $message);

	if (session_start() && !empty($_SESSION['login'])) {
		$flog = "<span>Ваш логигн: </span>" . $_SESSION['login'] . "<br><div><a href = 'login.php&do=logout'>Выйти из аккаунта</a></div>";
	} else {
		$flog = "<div><a href = 'login.php'>Войти в аккаунт</a></div><div><a href = 'admin.php'>Войти как админ</a></div>";
	}
	require_once("form.php");
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once(BASE_DIR . "src/UserData.php");
	require_once(BASE_DIR . "src/formHandler.php");
	$dbServerName = 'localhost';
	$dbUser = "u47556";
	$dbPassword = "2195834";
	$dbName = $dbUser;

	if (!empty($_POST)) {

		$userData = new UserData(
			$_POST['name'] ?? '',
			$_POST['email'] ?? '',
			$_POST['year'] ?? '',
			$_POST['gender'] ?? '',
			$_POST['numlimbs'] ?? '',
			$_POST['super-powers'] ?? '',
			$_POST['biography'] ?? '',
		);
		$errors = formHandler::checkUserData($userData);
	} else {
		header("Location: index.php");
		exit();
	}
	writeCookies('name', $errors, $userData->getName());
	writeCookies('email', $errors, $userData->getEmail());
	writeCookies('year', $errors, $userData->getYear());
	writeCookies('gender', $errors, $userData->getGender());
	writeCookies('numlimbs', $errors, $userData->getNumlimbs());
	writeCookies('biography', $errors, $userData->getBiography());

	if (isset($errors['super-powers'])) {
		setcookie('super-powers-error', $errors['super-powers'], time() + 60 * 60 * 24);
	} else {
		$supPowers = array('1' => '0', '2' => '0', '3' => '0');
		foreach ($userData->getSuperPowers() as $value) {
			$supPowers[$value] = '1';
		}
		foreach ($supPowers as $key => $value) {
			setcookie("super-powers[$key]", $value, time() + 60 * 60 * 24 * 365);
		}
	}


	if (count($errors) > 1) {
		header("Location: index.php");
		exit();
	}

	$db = new PDO("mysql:host=$dbServerName;dbname=$dbName", $dbUser, $dbPassword, array(PDO::ATTR_PERSISTENT => true));

	if (session_start() && !empty($_SESSION['login'])) {
		$userId = intval($_SESSION['loginid']);

		try {
			$sql = "UPDATE user2 SET name = :name, email = :email, date = :date, gender = :gender, limbs = :limbs, biography = :biography WHERE id = :id";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(
				'id' => $userId, 'name' => $userData->getName(), 'email' => $userData->getEmail(),
				'date' => intval($userData->getYear()), 'gender' => $userData->getGender(), 'limbs' => intval($userData->getNumlimbs()),
				'biography' => $userData->getBiography()
			));
		} catch (PDOException $e) {
			print('Error : ' . $e->getMessage());
			exit();
		}

		try {
			$sql = "DELETE FROM user_power2 WHERE id = :id";
			$stmt = $db->prepare($sql);
			$stmt->execute(array('id' => $userId));
		} catch (PDOException $e) {
			print('Error : ' . $e->getMessage());
			exit();
		}

		try {
			foreach ($userData->getSuperPowers() as $value) {
				$stmt = $db->prepare("INSERT INTO user_power2 (id, power) VALUES (:id, :power)");
				$stmt->execute(array('id' => $userId, 'power' => intval($value)));
			}
		} catch (PDOException $e) {
			print('Error : ' . $e->getMessage());
			exit();
		}
		setcookie("update", '1', time() + 60 * 60 * 24);
	} else {
		$lastId = null;

		try {
			$stmt = $db->prepare("INSERT INTO user2	(name, email, date, gender, limbs, biography) 
				VALUES (:name, :email, :date, :gender, :limbs, :biography)");

			$stmt->execute(array(
				'name' => $userData->getName(), 'email' => $userData->getEmail(), 'date' => intval($userData->getYear()),
				'gender' => $userData->getGender(), 'limbs' => intval($userData->getNumlimbs()),
				'biography' => $userData->getBiography()
			));

			$lastId = $db->lastInsertId();
		} catch (PDOException $e) {
			print('Error : ' . $e->getMessage());
			exit();
		}

		try {
			if ($lastId === null) {
				exit();
			}
			foreach ($userData->getSuperPowers() as $value) {
				$stmt = $db->prepare("INSERT INTO user_power2 (id, power) VALUES (:id, :power)");
				$stmt->execute(array('id' => $lastId, 'power' => intval($value)));
			}
		} catch (PDOException $e) {
			print('Error : ' . $e->getMessage());
			exit();
		}

		$login =  "user$lastId";
		$password = gen_password();
		try {
			$stmt = $db->prepare("INSERT INTO user_authentication (id, login, password) VALUES (:id, :login, :password)");
			$stmt->execute(array('id' => $lastId, 'login' => $login, 'password' => password_hash($password, PASSWORD_DEFAULT)));
		} catch (PDOException $e) {
			print('Error : ' . $e->getMessage());
			exit();
		}

		setcookie('login', $login, time() + 60 * 60 * 24);
		setcookie('password', $password, time() + 60 * 60 * 24);
		setcookie("save", '1', time() + 60 * 60 * 24);
	}

	$db = null;

	header("Location: index.php");
	exit();
}

function checkCookies($name, &$message)
{
	if (!empty($_COOKIE[$name])) {
		$message[$name] = $_COOKIE[$name];
	} else {
		$message[$name] = '';
	}
	if (!empty($_COOKIE[$name . '-error'])) {
		$message[$name . '-error'] = "<div class='error'>{$_COOKIE[$name . '-error']}</div>";
		setcookie($name . '-error', '', time() - 60 * 60 * 24);
	} else {
		$message[$name . '-error'] = '';
	}
}
function writeCookies($name, $errors, $userData)
{
	if (isset($errors[$name])) {
		setcookie($name . '-error', $errors[$name], time() + 60 * 60 * 24);
	} else {
		setcookie($name, $userData, time() + 60 * 60 * 24 * 365);
	}
}
function gen_password($length = 12)
{
	$chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP';
	$size = strlen($chars) - 1;
	$password = '';

	while ($length--) {
		$password .= $chars[random_int(0, $size)];
	}

	return $password;
}
