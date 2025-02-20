<?php
require_once('../DB_connection/db_connection.php');
require_once('../DB_connection/fetch_db.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

?>

<?php include('../assets/html/header.php'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">




    <div class="col-md-12 container p-4 mt-5 d-flex justify-content-center">
    <div class="card text-white bg-dark mb-3 p-5 w-100 align-items-center" style="width: 50rem;">
        <form action="../submit/submit_add_category.php" method="get">
            <div class="mb-4 col-md-12 ">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" name="product_name">
            </div>
            <button type="submit" class="btn btn-success">Add</button>
            <button type="reset" class="btn btn-primary">Reset</button>
            <a href="../admin_add_product.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="../style/styling.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include('../assets/html/footer.php'); ?>