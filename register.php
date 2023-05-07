<?php
include('config.php');

if (isset($_POST['submit'])) {
    $name = mysqli_escape_string($conn, $_POST['name']);
    $email = mysqli_escape_string($conn, $_POST['email']);
    $pass = mysqli_escape_string($conn, md5($_POST['pass']));
    $cpass = mysqli_escape_string($conn, md5($_POST['cpass']));
    $user_type = $_POST['user_type'];

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query falied');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'такой пользаватель существует!';
    } else {
        if ($pass !== $cpass) {
            $message[] = 'Пароли не совпадают';
        } else {
            mysqli_query($conn, "INSERT INTO `users` (`id`, `name`, `email`, `user_type`, `password`) VALUES (NULL, '$name', '$email', '$user_type', '$pass')") or die('query failed');
            $message[] = 'registered succesfuly';
            header('Location: login.php');
        }
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
            <h3>Зарегестрируйтесь</h3>
            <input type="text" name="name" placeholder="Ваш имя" required class="box">
            <input type="email" name="email" placeholder="Ваш email" required class="box">
            <input type="password" name="pass" placeholder="Ваш пароль" required class="box">
            <input type="password" name="cpass" placeholder="Подтвердите пароль" required class="box">
            <select name="user_type" class="box">
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>
            <input type="submit" name="submit" value="Зарегестрироваться" class="btn">
            <p>У вас есть акканут? <a href="login.php">Войти</a> </p>
        </form>
    </div>


</body>

</html>