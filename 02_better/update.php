
<?php


    /** @var $pdo PDO */
    require_once "database.php";

    $id = $_GET['id'] ?? null;

    if (!$id) {
        header('Location: index.php');
        exit;
    }

    $statement = $pdo->prepare("SELECT * FROM products WHERE id = :id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);



    $errors = [];

    $title = $product['title'];
    $description = $product['description'];
    $price = $product['price'];

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
            $imagePath = $product['image'];

            if ($image && $image['tmp_name']) {
                if ($product['image']) {
                    unlink($product['image']);
                }

                $imagePath = 'images/'.randomString(8).'/'.$image['name'];
                mkdir(dirname($imagePath));
                move_uploaded_file($image['tmp_name'], $imagePath);
            }

            $statement = $pdo->prepare("UPDATE products SET title = :title,
                                                                  image = :image,
                                                                  description = :description,
                                                                  price = :price
                                               WHERE id = :id");
                                                                  

            $statement->bindValue(':title', $title);
            $statement->bindValue(':image', $imagePath);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':id', $id);
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

        <h1>Update Product <b><?php echo $product['title']?></b></h1>

        <?php if (!empty($errors)):?>
            <div class="div alert alert-danger">
                <?php foreach($errors as $error): ?>
                    <div><?php echo $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <?php if ($product['image']):?>
                <img src="<?php echo $product['image'] ?>" class="old-thumbnail">
            <?php endif; ?>
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