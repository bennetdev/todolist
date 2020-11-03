<?php

require_once '../app/init.php';
require_once '../php/utilities.php';
require_once '../php/checkLoggedIn.php';

if(isset($_POST['id'])){
	$id = $_POST['id'];
	replaceChars($id);
	if(is_numeric($id)){
		$deleteKategorieQuery = $db->prepare("
			DELETE from kategorien
			WHERE id = :id
			AND user_id = :user_id
		");

		$deleteKategorieQuery->execute([
			'id' => $id,
			'user_id' => $_SESSION['user_id']
		]);

		$deleteTodoQuery = $db->prepare("
			DELETE from todo
			WHERE kategorie_id = :kategorie_id
			AND user_id = :user_id
		");
		$deleteTodoQuery->execute([
			'kategorie_id' => $id,
			'user_id' => $_SESSION['user_id']
		]);
	}
}
else{
	header("Location: ../index.php");
}
?>
