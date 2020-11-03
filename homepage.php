<?php
    
    require_once 'app/init.php';
    require_once 'php/checkLoggedIn.php';
    require_once 'app/key.php';
    $itemsQuery = $db->prepare("
        SELECT id, name, done, kategorie_id FROM todo WHERE user_id = :user_id
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

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

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
            <h4 class="modal-title">Edit Todo</h4>
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
    <div class="modal fade" id="aboutModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">About</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <p>Welcome to my todolist website. Click anywhere on the little &times; to remove things or click on the text to edit things. You can do this with todos and categories. Your data is stored online and encrypted, so you can see the same list on any device, but only on your account.<br/>For any improvment ideas contact me on <a href="https://bennetdev.de">bennetdev.de</a></p>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><?php echo $_SESSION['username']; ?></h3>
            </div>

            <ul class="list-unstyled components">
                <p>Todolist</p>
                <li>
                    <a id="about">About</a>
                </li>
                <li>
                    <a href="php/logout.php">Logout</a>
                </li>
            </ul>
        </nav>

        <div id="content">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" id="sidebarCollapse" class="collapse-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div> 
            </div>
            <div class="kategorie-add-div">
                    <h1>Neue Kategorie</h1>
                    <form class="kategorie-add" action="php/addKategorie.php" method="POST">
                        <input type="text" name="name" class="name">
                        <input type="submit" value="Add" class="submit btn">   
                    </form>   
                </div>
            <div id="todo-content" class="row">
                <?php foreach($kategorien as $kategorie): ?>
                    <div class="todo-list shadow"  id="kategorie-<?php echo $kategorie['id']; ?>">
                        <span class="close remove-kategorie">×</span>
                        <?php $kategorie_name = decryptData($kategorie['name'], $_SESSION['key']); ?>
                        <h1><a class="edit-kategorie"><?php echo $kategorie_name; ?></a></h1>
                        <form class="item-add" action="php/add.php" method="POST">
                            <input type="text" name="name" class="name">
                            <input type="submit" value="Add" class="submit btn">   
                        </form>
                        <ul>
                            <?php if(!empty($items)): ?>
                            <?php foreach($items as $item):
                                if($kategorie['id'] == $item['kategorie_id']): ?>
                                
                                    <li class="todo"><a id ="<?php echo $item['id']; ?>" class="<?php echo $item['done'] ? ' done' : ''; ?> edit-todo"><?php echo decryptData($item['name'], $_SESSION['key']); ?></a>
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
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $(this).toggleClass('active');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });

    </script>
</body>

</html>