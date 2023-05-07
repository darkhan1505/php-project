<?php
require('config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location: login.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./css/admin_style.css">
</head>

<body>

    <?php include('admin_header.php'); ?>

    <section class="dashboard">
        <h1 class="heading">dashboard</h1>

        <div class="box-container">
            <div class="box">
                <?php
                $total_pendings = 0;
                $select_pendings = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending' ") or die('select pendings failed');
                if (mysqli_num_rows($select_pendings) > 0) {
                    while ($fetch_pendings = mysqli_fetch_assoc($select_pendings)) {
                        $total_price = $fetch_pendings['total_price'];
                        $total_pendings += $total_price;
                    }
                }
                ?>
                <h3><?= $total_pendings ?></h3>
                <p>В ожидании</p>
            </div>

            <div class="box">
                <?php
                $total_completed = 0;
                $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed' ") or die('select completed failed');
                if (mysqli_num_rows($select_completed) > 0) {
                    while ($fetch_completed = mysqli_fetch_assoc($select_completed)) {
                        $total_price = $fetch_completed['total_price'];
                        $total_completed += $total_price;
                    }
                }
                ?>
                <h3><?= $total_completed ?></h3>
                <p>Заверешенный заказ</p>
            </div>

            <div class="box">
                <?php
                $order_placed = mysqli_query($conn, "SELECT * FROM `orders`") or die('order placed failed');
                $number_of_orders = mysqli_num_rows($order_placed);
                ?>
                <h3><?= $number_of_orders ?></h3>
                <p>order_placed(размещено)</p>
            </div>

            <div class="box">
                <?php
                $product_placed = mysqli_query($conn, "SELECT * FROM `products`") or die('product placed failed');
                $number_of_products = mysqli_num_rows($product_placed);
                ?>
                <h3><?= $number_of_products ?></h3>
                <p>Продуктов добавлено на сайт</p>
            </div>

            <div class="box">
                <?php
                $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('user query failed');
                $number_of_users = mysqli_num_rows($select_users);
                ?>
                <h3><?= $number_of_users ?></h3>
                <p>Обычных пользавателей</p>
            </div>

            <div class="box">
                <?php
                $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('admin query failed');
                $number_of_admins = mysqli_num_rows($select_admins);
                ?>
                <h3><?= $number_of_admins ?></h3>
                <p>Администраторов</p>
            </div>

            <div class="box">
                <?php
                $select_accounts = mysqli_query($conn, "SELECT * FROM `users`") or die('account query failed');
                $number_of_accounts = mysqli_num_rows($select_accounts);
                ?>
                <h3><?= $number_of_accounts ?></h3>
                <p>Пользавателей</p>
            </div>

            <div class="box">
                <?php
                $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('account query failed');
                $number_of_messages = mysqli_num_rows($select_messages);
                ?>
                <h3><?= $number_of_messages ?></h3>
                <p>Сообщений</p>
            </div>
        </div>
    </section>

    <script src="js/admin_script.js"></script>
</body>

</html>