<?php
require_once '../app/init.php';
require_once '../app/key.php';
require_once '../php/utilities.php';
require_once '../php/checkLoggedIn.php';

if(isset($_POST['name']) && isset($_POST['submit'])){
    $name = trim($_POST['name']);
    $kategorie_id = $_POST["kategorie_id"];
    replaceChars($name);
    if(!empty($name)){
        if(strlen($name) > 50){
            $name = substr($name, 0, 50);
        }
        $subkategorieQuery = $db->prepare("
			INSERT subkategorien (name, user_id, kategorie_id)
			VALUES (:name, :user_id, :kategorie_id)
		");
        $subkategorieQuery->execute([
            'name' => encryptData($name, $_SESSION['key']),
            'user_id' => $_SESSION['user_id'],
            "kategorie_id" => $kategorie_id
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
?>
