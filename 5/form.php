<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>Задание 5</title>
</head>

<body>
	<form action="index.php" method="post">
		<div class="form_header">
			<?php
			echo $fheader;
			?>
		</div>
		<div class="form_login">
		</div>
		<p>
			<label>Имя<br>
				<input placeholder="Имя" type="text" name="name" value="<?php echo $message['name']; ?>">
			</label>
			<?php echo $message['name-error']; ?>
		<p>
			<label>E-mail<br>
				<input placeholder="E-mail" type="text" name="email" value="<?php echo $message['email']; ?>">
			</label>
			<?php echo $message['email-error']; ?>
		</p>
		<p>
			<label>Год рождения<br>
				<select name="year">
					<option value="">Select...</option>
					<?php
						for ($i = 2008; $i >= 1900; --$i) {
							if ($i == $message['year']) {
								echo "<option value='$i' selected>$i</option>";
							} else {
								echo "<option value='$i'>$i</option>";
							}
						}
					?>
				</select>
			</label>
			<?php echo $message['year-error']; ?>
		</p>
		<p>Пол<br>
		<label>
			<?php
				if ($message['gender'] == 1) {
					echo "<input type='radio' name='gender' value='1' checked>М";
				} else {
					echo "<input type='radio' name='gender' value='1'>М";
				}
			?>
		</label>
		<label>
		<?php
			if ($message['gender'] == 2) {
				echo "<input type='radio' name='gender' value='2'checked>Ж";
			} else {
				echo "<input type='radio' name='gender' value='2'>Ж";
			}
		?>
		</label>
		</p>
		<p>
			<?php echo $message['gender-error']; ?>
		</p>
		<p>Количество конечностей<br>
		<?php
			for ($i = 1; $i <= 4; $i++) {
				if ($message['numlimbs'] == $i) {
					echo "<label><input type='radio' name='numlimbs' value='$i' checked>$i</label>";
				} else {
					echo "<label><input type='radio' name='numlimbs' value='$i'>$i</label>";
				}
			}
		?>
		<p>
		<?php echo $message['numlimbs-error']; ?>
		</p>
		</p>
		<p>
			<label>Сверхспособности<br>
			<select multiple name="super-powers[]" class="form__select">
				<option <?php echo ((isset($message["super-powers"]['1']) && $message["super-powers"]['1'] == '1') ? 'selected' : ''); ?> value="1">Бессмертие</option>
				<option <?php echo ((isset($message["super-powers"]['2']) && $message["super-powers"]['2'] == '1') ? 'selected' : ''); ?> value="2">Прохождение сквозь стены</option>
				<option <?php echo ((isset($message["super-powers"]['3']) && $message["super-powers"]['3'] == '1') ? 'selected' : ''); ?> value="3">Левитация</option>
			</select>
			</label>
			<?php echo $message['super-powers-error'] ?>
		</p>
		<div>
			<p>
				<label>Биография<br>
					<textarea placeholder="Расскажите о себе" name="biography"><?php echo $message['biography']; ?></textarea>
				</label>
				<?php echo $message['biography-error'] ?>
			</p>
		</div>
		<p>
			<label>
				<input type="checkbox" name="agree" required>С условиями контранктом ознакомлен
				(а)
			</label>
		</p>
		<p>
			<input type="submit" value="Отправить">
		</p>
		<p class="form_footer">
			
		</p>
	</form>
</body>

</html>