<?php ?>

<h1>Products CRUD</h1>

<div>
    <a href="/products/create" class="btn btn-success">Create Product</a>
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
            <td>
                <?php if($product['image']): ?>
                    <img src="/<?php echo $product['image'] ?>" class="thumbnail">
                <?php endif; ?>
            </td>
            <td><?php echo $product['title']?></td>
            <td><?php echo $product['price']?></td>
            <td><?php echo $product['create_date']?></td>
            <td>
                <a href="/products/update?id=<?php echo $product['id'] ?>" class="btn btn-outline-primary">Edit</a>
                <form method="post" action="/products/delete" style="display: inline-block">
                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                </form>

            </td>
        </tr>
    <?php }?>
    </tbody>
</table>
