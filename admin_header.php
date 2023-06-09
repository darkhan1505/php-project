
<header class="header">
    <div class="container">

        <a href="admin_page.php" class="logo">Admin <span>Panel</span></a>

        <nav  class="navbar">
            <a href="admin_page.php">home</a>
            <a href="admin_products.php">products</a>
            <a href="admin_orders.php">orders</a>
            <a href="admin_users.php">users</a>
            <a href="admin_contacts.php">messages</a>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>
        <div class="account-box">
            <p>username : <span><?= $_SESSION['admin_name'] ?></span></p>
            <p>email : <span><?= $_SESSION['admin_email'] ?></span></p>
            <a href="logout.php" class="delete-btn">logout</a>
        </div>
    </div>
</header>
<?php

if (isset($message)) {
    foreach ($message as $msg) {
        echo "
        <div class='message'>
            <span>". $msg ."</span>
            <i class='fas fa-times' onclick='this.parentElement.remove();'></i>
        </div>
        ";
    }
}
?>