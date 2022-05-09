<?php
    
    require_once '../database_credentials.php';
    require_once '../rest_base.php';

    if (!is_post()) {
        error('Użyto złej metody HTTP! Użyj metody POST!');
        return;
    }

    if (!isset($_SESSION['user_id'])) {
        error('Nie jesteś zalogowany!');
        return;
    }

    if (empty($_POST['product_id'])) {
        error('Nie podano identyfikatora produktu!');
        return;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    if (!ctype_digit($product_id)) {
        error('Podany identyfikator produktu jest nieprawidłowy!');
        return;
    }

    $fetched_user_id;
    $fetched_product_id;

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, 'SELECT product_id FROM products WHERE product_id = ?');

    mysqli_stmt_bind_param($statement, 'i', $product_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $fetched_product_id);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);

    if (!$fetched_product_id) {
        mysqli_close($connection);

        error('Podany identyfikator produkt jest nieprawidłowy!');
        return;
    }

    $statement = mysqli_prepare($connection, 'SELECT user_id FROM cart WHERE user_id = ? AND product_id = ?');

    mysqli_stmt_bind_param($statement, 'ii', $user_id, $product_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $fetched_user_id);
    mysqli_stmt_fetch($statement);
    mysqli_stmt_close($statement);

    if ($fetched_user_id) {
        mysqli_close($connection);

        error('Podany produkt jest już w koszyku!');
        return;
    }

    $statement = mysqli_prepare($connection, 'INSERT INTO cart VALUES (?, ?)');

    mysqli_stmt_bind_param($statement, 'ii', $user_id, $product_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    mysqli_close($connection);

    success('Produkt dodano pomyślnie do koszyka!');