<?php

    require_once '../database_credentials.php';
    require_once '../rest_base.php';

    $products = [];

    $connection = mysqli_connect(MYSQL_ADDRESS, MYSQL_USERNAME, MYSQL_PASSWORD, MYSQL_DATABASE);
    $result = mysqli_query($connection, 'SELECT * FROM products');

    while ($product = mysqli_fetch_assoc($result)) {
        array_push($products, $product);
    }

    mysqli_close($connection);
    success('Zwórocono pomyślnie listę produktów!', ['products' => $products]);