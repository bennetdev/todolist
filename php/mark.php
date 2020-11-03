<?php

require_once '../app/init.php';
require_once '../php/utilities.php';
require_once '../php/checkLoggedIn.php';

if(isset($_GET['as'], $_GET['todo'])){
	$as = $_GET['as'];
	$todo = $_GET['todo'];
	replaceChars($as);
	replaceChars($todo);

	switch ($as) {
		case 'done':
			$doneQuery = $db->prepare("
				UPDATE todo
				SET done = 1
				WHERE id = :todo
				AND user_id = :user_id
			");
			$doneQuery->execute([
				'todo' => $todo,
				'user_id' => $_SESSION['user_id']
			]);
			break;
		case 'notdone':
			$doneQuery = $db->prepare("
				UPDATE todo
				SET done = 0
				WHERE id = :todo
				AND user_id = :user_id
			");
			$doneQuery->execute([
				'todo' => $todo,
				'user_id' => $_SESSION['user_id']
			]);
			break;
	}
	
}
header("Location: ../index.php");