<?php
require_once('../DB_connection/db_connection.php');
require_once('../DB_connection/fetch_db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}
$res=[];
if (isset($_GET['id'])){
    $product_id = $_GET['id'];
    $res=fetch_single_product($product_id);
    $categories=all_categories();
}


?>

<?php include('../assets/html/header.php'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">




    <div class="col-md-6 container p-4">
        <div class="card text-white bg-dark mb-3 p-5 w-100 align-items-center" style="width: 50rem;">
        <form action="../submit/submit_edit.php" method="post" enctype="multipart/form-data">
            <div class="mb-2">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" class="form-control" name="product_name" value="<?=$res['name']?>">
            </div>
            <div class="mb-3 col-md-2">
                <label for="product_price" class="form-label">Price</label>
                <input type="number" class="form-control" name="product_price" value="<?=$res['price']?>">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" value="available" name="status" id="status" <?php if($res['status']=='available'){echo("checked");} ?>>
                <label class="form-check-label" for="status">
                    Available
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" value="out_of_stock" name="status" id="status" <?php if($res['status']=='out_of_stock'){echo("checked");} ?>>
                <label class="form-check-label" for="status">
                    Out of stock
                </label>
            </div>
            <div class="mb-3 col-md-4">
                <select class="form-select" name="category" aria-label="Select Category">
                    <option >Select Category</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category['id'] ?>" <?php if($category['id']==$res['category_id']){echo "selected";}  ?>><?= $category['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="image">Upload</label>
                <input type="file" class="form-control" name="image">
                <input type="hidden" name="pimage" id="pimage" value="<?php echo ($res['image']); ?>">
                <input type="hidden" name="id" id="id" value="<?php echo ($product_id); ?>">
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="reset" class="btn btn-primary">Reset</button>
            <a href="../all_products.php" class="btn btn-secondary">Cancel</a>

        </form>
    </div>
    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="../style/styling.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include('../assets/html/footer.php'); ?>