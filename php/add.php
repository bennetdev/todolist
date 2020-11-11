<?php

require_once '../app/init.php';
require_once '../php/utilities.php';
require_once '../php/checkLoggedIn.php';
require_once '../app/key.php';

if(isset($_POST['name']) && isset($_POST['submit'])){
	$name = trim($_POST['name']);
	$kategorie_id = $_POST['kategorie_id'];
	replaceChars($name);
	replaceChars($kategorie_id);
	if(is_numeric($kategorie_id)){
        if(strlen($name) > 50){
            $name = substr($name, 0, 50);
        }
		$checkQuery = $db->prepare("
					SELECT * FROM kategorien
					WHERE id = :kategorie_id
					AND user_id = :user_id
			");
		$checkQuery->execute([
					'kategorie_id' => $kategorie_id,
					'user_id' => $_SESSION['user_id']
			]);
		if(!empty($name) && $checkQuery->rowCount()){
			$addedQuery = $db->prepare("
					INSERT todo (name, user_id, done, created, kategorie_id)
					VALUES (:name, :user_id, 0, NOW(), :kategorie_id)
			");

			$addedQuery->execute([
				'name' => encryptData($name, $_SESSION['key']),
				'user_id' => $_SESSION['user_id'],
				'kategorie_id' => $kategorie_id

			]);
			$lastId = $db->lastInsertId();
			echo '<li class="todo"><a class="edit-todo" id="'.$lastId.'">'.$name.'</a>
                    <p class="due-days"></p>
	            <span class="close remove">×</span>
	        </li>';

		}	
	}
	
}
else{
	header("Location: ../index.php");
}