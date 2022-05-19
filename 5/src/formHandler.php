<?php

class formHandler
{
	public static function checkUserData(UserData $user): array
	{

		if (empty($user->getName())) {
			$errors['name'] = "Введите имя!";
		} elseif (!preg_match("/^\s*[a-zA-Zа-яА-Я'][a-zA-Zа-яА-Я-' ]+[a-zA-Zа-яА-Я']?\s*$/u", $user->getName())) {
			$errors['name'] = "Несуществующее имя!";
		}

		if (empty($user->getEmail())) {
			$errors['email'] = "Введите e-mail!";
		} elseif (!preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/", $user->getEmail())) {
			$errors['email'] = "Несуществующий e-mail!";
		}

		if (empty($user->getYear())) {
			$errors['year'] = "Выберите год!";
		}

		if (empty($user->getGender())) {
			$errors['gender'] = "Выберите пол!";
		} 

		if (empty($user->getNumlimbs())) {
			$errors['numlimbs'] = "Выберите кол-во конечностей!";
		} 

		if (empty($user->getSuperPowers())) {
			$errors['super-powers'] = "Выберите хотя бы одну суперспособность!";
		} 

		if (empty($user->getBiography())) {
			$errors['biography'] = "Расскажите что-нибудь о себе!";
		}
		return $errors;
	}
}