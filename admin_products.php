<?php
session_start();
include('config.php');
$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location: login.php');
}

if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $save_folder = 'uploaded_img/' . $image;

    $select_product_query = mysqli_query($conn, "SELECT `name` FROM `products` WHERE `name` = '$name'");
    if (mysqli_num_rows($select_product_query) > 0) {
        $message[] = 'Продукт с таким названием уже существует!';
    } else {
        if ($image_size > 2 * 1024 * 1024) {
            $message[] = 'Размер фото должен быть не более 2мб';
        } else {
            move_uploaded_file($image_tmp_name, $save_folder);
            mysqli_query($conn, "INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES (NULL, '$name', '$price', '$image')");
            $message[] = 'Продукт успешно добавлен!';
        }
    }
}


if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_img = mysqli_query($conn, "SELECT `image` FROM `products` WHERE `id` = '$delete_id'");
    $delete_img_assoc = mysqli_fetch_assoc($delete_img);
    mysqli_query($conn, "DELETE  FROM `products` WHERE `id` = '$delete_id'");
    unlink('uploaded_img/' . $delete_img_assoc['image']);
    header('location: admin_products.php');
}

if(isset($_POST['update-product'])) {
    $update_name = $_POST['update_name'];
    $update_image = $_POST['update_image'];
    $update_price = $_POST['update_price'];
    $update_p_id = $_POST['update_p_id'];

    mysqli_query($conn, "UPDATE `products` SET `name` = '$update_name', `price` = '$update_price' WHERE `id` = '$update_p_id'");
    
    if (!empty($update_image)) {
        
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
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>
    <?php require_once('admin_header.php'); ?>
    <div class="add-products">
        <h2>SHOP PRODUCTS</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <h3>add product</h3>
            <input class="input" type="text" name="name" class="box" placeholder="name products" required>
            <input class="input" type="number" name="price" min="0" class="box" placeholder="price products" required>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="input" required>
            <input type="submit" name="add_product" value="Добавить продукт" class="btn" />
        </form>
    </div>

    <section class="all_products">
        <?php $select_products = mysqli_query($conn, "SELECT * FROM `products`");
        if (mysqli_num_rows($select_products) > 0) {
            while ($select_product = mysqli_fetch_assoc($select_products)) { ?>
                <div class="box">
                    <img src="uploaded_img/<?= $select_product['image'] ?>" alt="">
                    <h3><?= $select_product['name'] ?></h3>
                    <p><?= $select_product['price'] ?></p>
                    <a href="?update=<?= $select_product['id'] ?>" class="btn">Обновить</a>
                    <a href="?delete=<?= $select_product['id'] ?>" onclick="confirm('Вы точно хотите удалить этот товар?');" class="delete-btn">Удалить</a>
                </div>
        <?php }
        } else {
            echo "<p>На данный момент продуктов нету</p>";
        } ?>
    </section>


    <?php
    if (isset($_GET['update'])) {
        echo "<section class='update-form'>";
        $update_id = $_GET['update'];
        $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE `id` = '$update_id'");
        if (mysqli_num_rows($update_query) > 0) {
            while ($fetch_update = mysqli_fetch_assoc($update_query)) {
    ?>
            <form action="" method="post" enctype="multipart/form-data">
                <img src='uploaded_img/<?= $fetch_update['image'] ?>' />
                <input type="hidden" value="<?=$fetch_update['id']?>" name="update_p_id">
                <input type='file'   class="box" name="update_image" accept='image/jpeg, image/jpg, image/png'  />
                <input type='text'   class="box" name="update_name" placeholder='Имя продукта' value='<?= $fetch_update["name"] ?>' required />
                <input type='number' class="box"  name="update_price" min='0' max='999999' placeholder='Цена продукта' value='<?= $fetch_update["price"] ?>' required />
                <input type='submit' class="option-btn" value="сохранить"  name='update_product' />
                <input type='reset' class="delete-btn" id="delete-btn" value="отмена"  name='update_product' />
            </form>

    <?php }
        } else {
            echo "Такого продукта не существует";
        }
        echo "</section>";
    } ?>
    ?>

    <script src="js/admin_script.js"></script>

</body>

</html>