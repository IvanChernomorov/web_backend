<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>Задание 3</title>
</head>

<body>
	<form action="form.php" method="post">
		<p>
			<label>Имя<br>
				<input placeholder="Имя" type="text" name="name" value="">
			</label>
		<p>
			<label>E-mail<br>
				<input placeholder="E-mail" type="text" name="email" value="">
			</label>
		</p>
		<p>
			<label>Год рождения<br>
				<select name="year">
					<option value="">Select...</option>
					<?php
					for ($i = 2008; $i >= 1900; --$i) {
						echo "<option value='$i'>$i</option>";
					}
					?>
				</select>
			</label>
		</p>
		<p>Пол<br>
			<label>
				<input type="radio" name="gender" value="man">Мужской
			</label>
			<label>
				<input type="radio" name="gender" value="woman">Женский
			</label>
		</p>
		<p>Количество конечностей<br>
			<label>
				<input type="radio" name="limb" value="1">1
			</label>
			<label>
				<input type="radio" name="limb" value="2">2
			</label>
			<label>
				<input type="radio" name="limb" value="3">3
			</label>
			<label>
				<input type="radio" name="limb" value="4">4
			</label>
		</p>
		<p>
			<label>Сверхспособности<br>
				<select multiple name="super-powers[]">
					<option value="immortality">Бессмертие</option>
					<option value="walkthrough-walls">Прохождение сквозь стены</option>
					<option value="levitation">Левитация</option>
				</select>
			</label>
		</p>
		<div>
			<p>
				<label>Биография<br>
					<textarea placeholder="Расскажите о себе" name="biography"></textarea>
				</label>
			</p>
		</div>
		<p>
			<label>
				<input type="checkbox" name="agree">С условиями контранктом ознакомлен
				(а)
			</label>
		</p>
		<p>
			<input type="submit" value="Отправить">
		</p>
	</form>
	<p>
		Создал таблицы user и user_power в базе данных
		<img src="1.jpg" alt="screen_1">
	</p>
	<p>
		Вывел информацию о таблице user а также вывел содержимое таблиц user и user_power
		<img src="2.jpg" alt="screen_2">
	</p>
</body>

</html>
