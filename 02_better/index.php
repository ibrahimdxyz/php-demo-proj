<?php
    /** @var $pdo PDO */
    require_once "database.php";

    $search = $_GET['search'] ?? '';
    if ($search) {
        $statement = $pdo->prepare('SELECT * FROM products WHERE title LIKE :title ORDER BY CREATE_DATE DESC');
        $statement->bindValue(':title', "%$search%");

    } else {
        // select products
        $statement = $pdo->prepare('SELECT * FROM products ORDER BY CREATE_DATE DESC');
    }

    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>


<?php include_once "views/partials/header.php"?>

<h1>Products CRUD</h1>

<div>
    <a href="create.php" class="btn btn-success">Create Product</a>
</div>



<form>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search for Products" name="search" value="<?php echo $search?>">
        <div class="input-group-append">
            <button type="submit" class="btn btn-outline-secondary" basic-addon2">🔍</button>
        </div>
    </div>
</form>

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
                <a href="update.php?id=<?php echo $product['id'] ?>" class="btn btn-outline-primary">Edit</a>
                <form action="delete.php" method="post" style="display: inline-block">
                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                </form>

            </td>
        </tr>
    <?php }?>
    </tbody>
</table>

<?php include_once "views/partials/footer.php"?>
