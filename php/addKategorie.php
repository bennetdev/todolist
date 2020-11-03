<?php
require_once '../app/init.php';
require_once '../app/key.php';
require_once '../php/utilities.php';
require_once '../php/checkLoggedIn.php';

if(isset($_POST['name']) && isset($_POST['submit'])){
	$name = trim($_POST['name']);
	replaceChars($name);

	
	if(!empty($name)){
		$kategorieQuery = $db->prepare("
			INSERT kategorien (name, user_id)
			VALUES (:name, :user_id)
		");
		$kategorieQuery->execute([
			'name' => encryptData($name, $_SESSION['key']),
			'user_id' => $_SESSION['user_id']
		]);
		$lastId = $db->lastInsertId();
		echo '<div class="todo-list shadow"  id="kategorie-'.$lastId.'">
				<span class="close remove-kategorie">×</span>
		            <h1><a class="edit-kategorie">'.$name.'</a></h1>
		                <form class="item-add" action="php/add.php" method="POST">
		                    <input type="text" name="name" class="name">
		                    <input type="submit" value="Add" class="submit btn">   
		                </form>   
		                <ul>
		                </ul>
		            </div>';
	}
}
else{
	header("Location: ../index.php");
}