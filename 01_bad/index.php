<?php
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'phpmyadmin', 'phpmyadmin'); $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // select products
    $statement = $pdo->prepare('SELECT * FROM products ORDER BY CREATE_DATE DESC');
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script> -->
        <link rel="stylesheet" href="style.css">
        <title>Products CRUD</title>
    </head>
    <body>
    <h1>Products CRUD</h1>

    <div>
        <a href="create.php" class="btn btn-success">Create Product</a>

    </div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Title</th>
            <th scope="col">Price</th>
            <th scope="col">Creation Date</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($products as $i => $product) { ?>
            <tr>
                <th scope="row"><?php echo $i + 1 ?></th>
                <td><img src="<?php echo $product['image'] ?>" class="thumbnail"></td>
                <td><?php echo $product['title']?></td>
                <td><?php echo $product['price']?></td>
                <td><?php echo $product['create_date']?></td>
                <td>
                    <a href="update.php?id=<?php echo $product['id'] ?>"  class="btn btn-outline-primary">Edit</a>
                    <form action="delete.php" method="post" style="display: inline-block">
                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </form>

                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
    </body>
</html>