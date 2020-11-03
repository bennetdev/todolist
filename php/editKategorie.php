<?php

require_once '../app/init.php';
require_once '../php/utilities.php';
require_once '../php/checkLoggedIn.php';
require_once '../app/key.php';

if(isset($_POST['submit'])){
	$id = $_POST['id'];
	$name = $_POST['name'];
	replaceChars($name);
	replaceChars($id);
	$editQuery = $db->prepare("
		UPDATE kategorien
		SET name = :name
		WHERE id = :id
		AND user_id = :user_id
	");
	$editQuery->execute([
		'id' => $id,
		'name' => encryptData($name, $_SESSION['key']),
		'user_id' => $_SESSION['user_id']
	]);
	
}
?>
<script type="text/javascript">
	var id = '<?php echo $id; ?>';
	var name='<?php echo $name; ?>';
</script>
