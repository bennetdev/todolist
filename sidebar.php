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
