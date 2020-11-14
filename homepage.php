<?php
    
    require_once 'app/init.php';
    require_once 'php/checkLoggedIn.php';
    require_once 'app/key.php';
    $itemsQuery = $db->prepare("
        SELECT id, name, done, kategorie_id, due_to, (DATE(due_to) < DATE(NOW()) AND NOT done) as overdue, DATE(due_to) - DATE(NOW()) as dueDays FROM todo WHERE user_id = :user_id
    ");
    $itemsQuery->execute([
        'user_id' => $_SESSION['user_id']
    ]);

    $items = $itemsQuery->rowCount() ? $itemsQuery->fetchAll(\PDO::FETCH_ASSOC) : [];


    $kategorieQuery = $db->prepare("
        SELECT id, name, user_id FROM kategorien WHERE user_id = :user_id
    ");
    $kategorieQuery->execute([
        'user_id' => $_SESSION['user_id']
    ]);

    $kategorien = $kategorieQuery->rowCount() ? $kategorieQuery->fetchAll(\PDO::FETCH_ASSOC) : [];


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Todolist</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="functions.js"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


</head>

<body>
    <?php require 'modalEditKategorie.php'; ?>
    <?php require 'modalEditTodo.php'; ?>
    <div class="modal fade" id="submitRemoveModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Delete category</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <p>Deleting the category will delete all todos in that category.</p>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer modal-footer-remove">
            <button type="button" id="submit-remove-kategorie" class="btn submit" data-dismiss="modal">Confirm</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
          <p class="debugModal"></p>
        </div>
      </div>
    </div>
    <div class="wrapper">
        <?php require 'sidebar.php'; ?>
            <div class="kategorie-add-div">
                <h1>New Category</h1>
                <div class="row">
                    <div class="col-sm-11">
                        <form class="kategorie-add" action="php/addKategorie.php" method="POST">
                            <input type="text" name="name" class="name">
                            <input type="submit" value="Add" class="submit btn add-btn">
                        </form>
                    </div>
                    <div class="col-sm-1 text-center">
                        <span class="material-icons md-36" id="settings">settings</span>
                    </div>
                    <?php require 'settingsModal.php'; ?>
                </div>
            </div>
            <?php require 'aboutModal.php'; ?>
            <div id="todo-content" class="row">
                <?php foreach($kategorien as $kategorie): ?>
                    <div class="todo-list shadow"  id="kategorie-<?php echo $kategorie['id']; ?>">
                        <span class="close remove-kategorie">×</span>
                        <?php $kategorie_name = decryptData($kategorie['name'], $_SESSION['key']); ?>
                        <h1><a class="edit-kategorie"><?php echo $kategorie_name; ?></a></h1>
                        <form class="item-add" action="php/add.php" method="POST">
                            <div class="form-group">
                                <input type="text" name="name" class="name">
                                <input type="submit" value="Add" class="submit btn add-btn">
                            </div>
                        </form>
                        <ul>
                            <?php if(!empty($items)): ?>
                            <?php foreach($items as $item):
                                if($kategorie['id'] == $item['kategorie_id']): ?>
                                    <li class="todo">
                                        <div class="todo-name-wrapper">
                                             <a id ="<?php echo $item['id']; ?>" class="<?php echo $item['done'] ? ' done' : ''; ?> edit-todo">
                                                <?php echo decryptData($item['name'], $_SESSION['key']); ?>
                                             </a>
                                        </div>
                                        <p class="due-days <?php echo $item['overdue'] ? 'redText' : 'greenText' ?>"><?php echo !$item["done"] ? $item["dueDays"] : "" ?></p>
                                        <span class="close remove">×</span>
                                    </li>
                                <?php endif; ?>   
                            <?php endforeach; ?>
                            <?php unset($item); ?>
                        <?php else: ?>
                            <p>No todos</p>
                        <?php endif; ?>
                        </ul>
                        
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
        <p class="debug"></p>
    <script type="text/javascript">


    </script>
</body>

</html>