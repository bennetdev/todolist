<?php
	require_once '../app/init.php';
	require_once '../php/utilities.php';
	require_once '../php/checkLoggedIn.php';
	require_once '../app/key.php';


	if(true){
		$id = $_POST['id'];
		$todoQuery = $db->prepare("
			SELECT * FROM todo
			WHERE user_id = :user_id
			AND id = :id
		");
		$todoQuery->execute([
			'id' => $id,
			'user_id' => $_SESSION['user_id']
		]);
		$todos = $todoQuery->rowCount() ? $todoQuery->fetchAll(\PDO::FETCH_ASSOC) : [];

		if(true){
			foreach ($todos as $todo) {
				$description = $todo['description'] ? decryptData($todo['description'], $_SESSION['key']) : $todo['description'];
				$name = decryptData($todo['name'], $_SESSION['key']);
				$done = $todo['done'];
				replaceChars($name);
				replaceChars($description);
				replaceChars($done);
			}
		}
	
	
	}

?>

<script type="text/javascript">
	var id = '<?php echo $id; ?>';
	var name='<?php echo $name; ?>';
	var description = '<?php echo $description; ?>';
	var done = '<?php echo $done; ?>';
	$("#todo-name").val(name);
	$(".modal-footer-todo").attr("id","modal-"+id);
	$("#todo-description").val(description);
	if(done == '1'){
		$("#todo-done").prop('checked', true);
	}
	else{
		$("#todo-done").prop('checked', false);
	}

</script>