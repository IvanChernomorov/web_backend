<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style2.css">
	<title>Login</title>
</head>

<body>
	<div class="form">

		<form class="form__body" action="" method="post">
			<div class="form_header">
			<?php echo $lheader; ?>
			</div>
			<div>
				<label class="form__label">
					<input class="form__input form__input_text" placeholder="Логин" type="text" name="login">
				</label>
				<?php echo $message['login-error']; ?>
			</div>
			<div>
				<label class="form__label">
					<input class="form__input form__input_text" placeholder="Пароль" type="password" name="password">
				</label>
				<?php echo $message['password-error']; ?>
			</div>
			<div class="form__item form__item_submit">
				<label class="form__label">
					<input class="form__submit" type="submit" value="Войти">
				</label>
			</div>
		</form>
</body>

</html>
