<?php if (!empty($errors)):?>
    <div class="div alert alert-danger">
        <?php foreach($errors as $error): ?>
            <div><?php echo $error ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<div>
    <a href="/products" class="btn btn-secondary">Go back to Products</a>
</div>


<form action="" method="post" enctype="multipart/form-data">

    <?php if ($product['image']):?>
        <img src="/<?php echo $product['image'] ?>" class="old-thumbnail">
    <?php endif; ?>

    <div class="mb-3">
        <label class="form-label">Product Image</label>
        <div>
            <input type="file" name="image">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Product title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $product['title'] ?>">
    </div>

    <div class="mb-3">
        <label class="form-label">Product Description</label>
        <textarea class="form-control" name="description" value="<?php echo $product['description'] ?>"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Product Price</label>
        <input type="number" step=".01" class="form-control" name="price" value="<?php echo $product['price'] ?>">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
