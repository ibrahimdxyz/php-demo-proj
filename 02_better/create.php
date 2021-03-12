<?php

    /** @var $pdo PDO */
    require_once "database.php";

    $errors = [];

    $title = '';
    $description = '';
    $price = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $date = date("Y-m-d H:i:s");

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
            $image = $_FILES['image'] ?? null;
            $imagePath = '';

            if ($image && $image['tmp_name']) {
                $imagePath = 'images/'.randomString(8).'/'.$image['name'];
                mkdir(dirname($imagePath));
                move_uploaded_file($image['tmp_name'], $imagePath);
            }

            $statement = $pdo->prepare("INSERT INTO products (title, image, description, price, create_date)
                                            VALUES (:title, :image, :description, :price, :date) ");

            $statement->bindValue(':title', $title);
            $statement->bindValue(':image', $imagePath);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':date', $date);
            $statement->execute();


            header('Location: index.php');
        }
    }


    /**
     * generates a random string with a given length
     * @param $n : string length
     * @return string $str
     */
    function randomString(int $n): string
    {
        $characters = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = '';
        for ($i=0; $i<$n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $str .= $characters[$index];
        }

        return $str;
    }
?>
<?php include_once "views/partials/header.php"?>
        <div>
            <a href="index.php" class="btn btn-secondary">Go back to Products</a>
        </div>

        <h1>Create New Product</h1>
        <?php if (!empty($errors)):?>
            <div class="div alert alert-danger">
                <?php foreach($errors as $error): ?>
                    <div><?php echo $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Product Image</label>
            <div>
                    <input type="file" name="image">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Product title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $title ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Product Description</label>
                <textarea class="form-control" name="description" value="<?php echo $description ?>"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Price</label>
                <input type="number" step=".01" class="form-control" name="price" value="<?php echo $price ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
<?php include_once "views/partials/footer.php"?>
