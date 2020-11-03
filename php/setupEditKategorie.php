<?php
	require_once '../app/init.php';
	require_once '../php/utilities.php';
	require_once '../php/checkLoggedIn.php';
	require_once '../app/key.php';


	if(true){
		$id = $_POST['id'];
		$kategorieQuery = $db->prepare("
			SELECT * FROM kategorien
			WHERE user_id = :user_id
			AND id = :id
		");
		$kategorieQuery->execute([
			'id' => $id,
			'user_id' => $_SESSION['user_id']
		]);
		$kategorien = $kategorieQuery->rowCount() ? $kategorieQuery->fetchAll(\PDO::FETCH_ASSOC) : [];

		if(true){
			foreach ($kategorien as $kategorie) {
				$name = decryptData($kategorie['name'], $_SESSION['key']);
				replaceChars($name);
			}
		}
	
	
	}

?>

<script type="text/javascript">
	var id = '<?php echo $id; ?>';
	var name='<?php echo $name; ?>';
	$("#kategorie-name").val(name);
	$(".modal-footer-kategorie").attr("id","modal-"+id);
</script>