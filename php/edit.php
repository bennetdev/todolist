<?php

require_once '../app/init.php';
require_once '../php/utilities.php';
require_once '../php/checkLoggedIn.php';
require_once '../app/key.php';

if(isset($_POST['submit'])){
	$id = $_POST['id'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	$done = $_POST['done'];
	$doneBool = $done;
	$due_to = $_POST["due_to"];
	if($due_to == ""){
	    $due_to = null;
    }
	else{
        $due_to = date('Y-m-d', strtotime($due_to));
    }
	if($doneBool == 'true'){
		$done = '1';
	}
	else{
		$done = '0';
	}
	replaceChars($name);
	replaceChars($description);
	replaceChars($done);
	replaceChars($id);
    if(strlen($name) > 50){
        $name = substr($name, 0, 50);
    }
    if(strlen($description) > 500){
        $description = substr($description, 0, 500);
    }
	$editQuery = $db->prepare("
		UPDATE todo
		SET done = :done, name = :name, description = :description, due_to = :due_to
		WHERE id = :id
		AND user_id = :user_id
	");
	$editQuery->execute([
		'id' => $id,
		'done' => $done,
		'name' => encryptData($name, $_SESSION['key']),
		'description' => encryptData($description, $_SESSION['key']),
		'user_id' => $_SESSION['user_id'],
        'due_to' => $due_to
	]);
	
}
?>