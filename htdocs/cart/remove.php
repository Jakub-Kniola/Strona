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
        error('Nie podatno identyfikatora produktu!');
        return;
    }

    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    if (!ctype_digit($product_id)) {
        error('Podano identyfikator produktu jest nieprawidłowy!');
        return;
    }

    $fetched_user_id;

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, 'SELECT user_id FROM cart WHERE user_id = ? AND product_id = ?');

    mysqli_stmt_bind_param($statement, 'ii', $user_id, $product_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $fetched_user_id);
    mysqli_stmt_fetch($statement);

    if (!$fetched_user_id) {
        mysqli_stmt_close($statement);
        mysqli_close($connection);

        error('Podany produkt nie znajduje się koszyku!');
        return;
    }

    $statement = mysqli_prepare($connection, 'DELETE FROM cart WHERE user_id = ? AND product_id = ?');

    mysqli_stmt_bind_param($statement, 'ii', $user_id, $product_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    mysqli_close($connection);

    success('Produkt usunięto pomyślnie z koszyka!');