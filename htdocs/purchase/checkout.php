<?php

    require_once '../database_credentials.php';
    require_once '../rest_base.php';
    
    if (!is_get()) {
        error('Użyto złej metody HTTP! Użyj metody GET!');
        return;
    }

    if (!isset($_SESSION['user_id'])) {
        error('Nie jesteś zalogowany!');
        return;
    }

    $user_id = $_SESSION['user_id'];

    $fetched_product_id;
    $fetched_price;

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $statement = mysqli_prepare($connection, 'SELECT products.product_id, products.price FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE user_id = ?');

    mysqli_stmt_bind_param($statement, 'i', $user_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $fetched_product_id, $fetched_price);

    while (mysqli_stmt_fetch($statement)) {
        $statement2 = mysqli_prepare($connection, 'INSERT INTO purchase VALUES (NULL, ?, ?, ?, NULL)');

        mysqli_stmt_bind_param($statement2, 'iii', $user_id, $fetched_product_id, $fetched_price);
        mysqli_stmt_execute($statement2);
        mysqli_stmt_close($statement2);
    }

    if (empty($fetched_product_id)) {
        mysqli_close($connection);

        error('Koszyk jest pusty!');
        return;
    }

    mysqli_stmt_close($statement);

    $statement = mysqli_prepare($connection, 'DELETE FROM cart WHERE user_id = ?');

    mysqli_stmt_bind_param($statement, 'i', $user_id);
    mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    mysqli_close($connection);

    success('Przedmioty z koszyka zostały zakupione!');


