<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin</title>
</head>

<body>
	<a href='index.php'>Выйти</a>
	<table border="1" width="100%" cellpadding="5">
		<tr>
			<th>ID</th>
			<th>Имя</th>
			<th>e-mail</th>
			<th>Год</th>
			<th>Пол</th>
			<th>Конечности</th>
			<th>Биография</th>
			<th>Действие</th>
		</tr>
		<?php
		foreach ($dbRequester->getUsersData() as $key => $value) {
			echo "
			<tr>
				<td>" . intval($value['id']) . "</td>
				<td>" . htmlspecialchars($value['name']) . "</td>
				<td>" . htmlspecialchars($value['email']) . "</td>
				<td>" . intval($value['date']) . "</td>
				<td>" . (intval($value['gender']) == 1 ? 'M' : 'W') . "</td>
				<td>" . intval($value['limbs']) . "</td>
				<td>" . htmlspecialchars($value['biography']) . "</td>
				<td><a href='?action=delete&id=" . intval($value['id']) . "'>delete user</a>		<a href='?action=change&id=" . intval($value['id']) . "'>change data</a></td>
			</tr>";
		}
		?>
		<table border="1" width="25%" cellpadding="5">
	<tr>
		<th>ID</th>
		<th>Суперспособность</th>
	</tr>
	<tr>
		<?php
		foreach ($dbRequester->getSupPowUsersData() as $key => $value) {
			echo "
			<tr>
				<td>" . htmlspecialchars($value['id']) . "</td>
				<td>" . htmlspecialchars($value['power']) . "</td>
			</tr>";
		}
		?>
	</tr>
</table>
		<table border="1" width="25%" cellpadding="5">
			<tr>
				<th>Суперспособность</th>
				<th>Количество</th>
			</tr>
			<?php
			foreach ($dbRequester->getNamesSupPower() as $key => $value) {
				echo"
				<tr>
					<td>" . htmlspecialchars($value['power']) . "</td>
					<td>" . intval($dbRequester->getCountUsersSupPower($value['id'])) . "</td>
				</tr>";
			}
			?>
		</table>
</body>

</html>
