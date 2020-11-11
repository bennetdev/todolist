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

        foreach ($todos as $todo) {
            $description = $todo['description'] ? decryptData($todo['description'], $_SESSION['key']) : $todo['description'];
            $name = decryptData($todo['name'], $_SESSION['key']);
            $done = $todo['done'];
            $due_to = $todo["due_to"];
            replaceChars($name);
            replaceChars($description);
            replaceChars($done);
        }
	
	
	}

?>

<script type="text/javascript">
	var id = '<?php echo $id; ?>';
	var name='<?php echo $name; ?>';
	var description = '<?php echo $description; ?>';
	var done = '<?php echo $done; ?>';
	var due_to = '<?php echo $due_to; ?>';
	$("#todo-name").val(name);
	$(".remaining-chars.name").html(name.length + "/50")
    $(".remaining-chars.description").html(description.length + "/500")
	$(".modal-footer-todo").attr("id","modal-"+id);
	$("#todo-description").val(description);
	$("#due-to-input").val(due_to)
	if(done == '1'){
		$("#todo-done").prop('checked', true);
	}
	else{
		$("#todo-done").prop('checked', false);
	}
    if(!due_to){
        $("#enable-due-to").prop('checked', false);
        $("#due-to-input").attr('readonly', true);
    }
    else{
        $("#enable-due-to").prop('checked', true);
        $("#due-to-input").attr('readonly', false);
    }

</script>