<?php
$title = $_POST["title"];
$description = $_POST["description"];
$price = $_POST["price"];

$image = $_FILES['image'] ?? null;
$imagePath = '';


if (!$title) {
    $errors[] = "Product title is required";
}

if (!$price) {
    $errors[] = "Product price is required";
}

if (!is_dir('images')) {
    mkdir('images');
}

if (empty($errors)) {
    // image doesn't seem to be perse null when there is no image uploaded

    if ($image && $image['tmp_name']) {
        if ($product['image']) {
            unlink($product['image']);
        }

        $imagePath = 'images/'.randomString(8).'/'.$image['name'];
        mkdir(dirname($imagePath));
        move_uploaded_file($image['tmp_name'], $imagePath);
    }

    header('Location: index.php');
}
