<?php

require_once '../app/init.php';
require_once '../php/utilities.php';
require_once '../php/checkLoggedIn.php';

if(isset($_POST['id'])){
	$id = $_POST['id'];
	replaceChars($id);
	if(is_numeric($id)){
		$addedQuery = $db->prepare("
			DELETE from todo
			WHERE id = :id
			AND user_id = :user_id
		");

		$addedQuery->execute([
			'id' => $id,
			'user_id' => $_SESSION['user_id']
		]);
	}
}
else{
	header("Location: ../index.php");
}
?>
