<?php

    require_once '../database_credentials.php';
    require_once '../rest_base.php';

    if (!is_get()) {
        error('Użyto złej metody HTTP! Użyj metody GET!');
        return;
    }

    if (empty($_GET['product_id'])) {
        error('Nie podatno identyfikatora produktu!');
        return;
    }

    $product_id = $_GET['product_id'];

    if (!ctype_digit($product_id)) {
        error('Podano identyfikatora produktu jest nieprawidłowy!');
        return;
    }

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, 'SELECT * FROM products WHERE product_id = ?');

    mysqli_stmt_bind_param($statement, 'i', $product_id);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);
    $product = mysqli_fetch_assoc($result);

    mysqli_stmt_close($statement);
    mysqli_close($connection);

    if (!$product) {
        error('Podano zły identyfikator produktu!');
        return;
    }

    success('Zwórocono pomyślnie produkt!', ['product' => $product]);