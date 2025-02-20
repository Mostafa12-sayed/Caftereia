<?php
require_once('./DB_connection/db_connection.php');
require_once('./DB_connection/fetch_db.php');
$categories = all_categories();
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ./login.php');
    exit();
}

// var_dump($_SESSION['errors']['price']);




?>




<?php include('./assets/html/header.php'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<div class="col-md-6 container p-4">
<div class="card text-white bg-dark mb-3 p-5 w-100 align-items-center" style="width: 50rem;">
        <form action="submit/submit_add_product.php" method="post" enctype="multipart/form-data">
            <div class="mb-2">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="product_name" required>
            </div>
            <div class="mb-3 col-md-2">
                <label for="product_price" class="form-label">Price</label>
                <input type="number" class="form-control" name="product_price" required>
                <?php if (isset($_SESSION['errors']["price"])){ ?> <p class="is-invalid"><?= $_SESSION['errors']['price'] ?></p><?php }; ?>
            </div>
            <div class="mb-3 col-md-12 d-flex row">
                <div class="mb-3 col-md-6">
                <select class="form-select col-md-12" name="category" aria-label="Select Category" required>
                    <option selected>Select Category</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php } ?>
                </select>
                </div>
                <div class="mb-3 col-md-6 row">
                <a href="referral_pages/add_category.php" class="btn btn-info">Add Category</a>
                </div>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="image">Upload</label>
                <input type="file" class="form-control" name="image" required>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="reset" class="btn btn-primary">Reset</button>
            <a href="./all_products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
    <style>
    label{
        color:aliceblue;
    }
    </style>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="./style/styling.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include('./assets/html/footer.php'); ?>