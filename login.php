<?php
include('config.php');
session_start();

if (isset($_POST['submit'])) {
    $email = mysqli_escape_string($conn, $_POST['email']);
    $pass = mysqli_escape_string($conn, md5($_POST['pass']));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query falied');

    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);

        if($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];

            header('location: admin_page.php');

        }elseif($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];

            header('location: home.php');
        }
        
    } else {
        $message[] = 'Пароль или логин неправильный';
    }
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
    <link rel="stylesheet" href="css/style.css">
</head>

<body>



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

    <div class="form-container">
        <form action="" method="post">
            <h3>Войдите в аккаунт</h3>
            <input type="email" name="email" placeholder="Ваш email" required class="box">
            <input type="password" name="pass" placeholder="Ваш пароль" required class="box">
            <input type="submit" name="submit" value="Войти" class="btn">
            <p>У вас нет акканута? <a href="register.php">зарегестрироваться</a> </p>
        </form>
    </div>

</body>

</html>