<?php
session_start();
require_once 'connection_db.php';
require_once 'myorders_function.php';
if (!isset($_SESSION['login'])) {
    header('Location: myorders_user.php');
    exit;
}
$products = getProducts(); // Only get products, not users

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Always use logged-in user's ID
    $user_id = $_SESSION['user_id'];
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);
    $room = filter_input(INPUT_POST, 'room', FILTER_SANITIZE_STRING);
    $products_data = json_decode($_POST['products_json'], true);

    if ($room && $products_data) {
        $order_id = createOrder($user_id, $room, $notes, $products_data);

        if ($order_id) {
            header('Location: myorders_user.php?success=1');
            exit;
        }
    }
    header('Location: myorders_user.php?error=1');
    exit;
}
?>


<?php include('./assets/html/header.php') ?>
<div class="container-fluid py-4">
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Order created successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Please enter your order.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Your Order</h5>
                </div>
                <div class="card-body">
                    <form id="orderForm" method="POST">
                        <div class="selected-products mb-4"></div>
                        <div class="form-group mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" rows="2" placeholder="Special instructions..."></textarea>
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label">Room</label>
                            <select class="form-select" name="room" required>
                                <option value="">Select Room</option>
                                <option value="room1">Room 1</option>
                                <option value="room2">Room 2</option>
                                <option value="room3">Room 3</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-top pt-3">
                            <div class="order-total">
                                <span class="text-muted">Total:</span>
                                <span class="h5 mb-0 ms-2">EGP 0</span>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check me-2"></i>Confirm Order
                            </button>
                        </div>
                        <input type="hidden" name="products_json" id="products_json">
                        <input type="hidden" name="user" id="selected_user" value="<?= $user_id ?>">
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row row-cols-2 row-cols-md-4 g-4">
                        <?php foreach ($products as $product): ?>
                            <div class="col">
                                <div class="product-card" data-id="<?= $product['id'] ?>">
                                    <div class="product-image-container">
                                        <img src="assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                                            class="product-image"
                                            alt="<?= htmlspecialchars($product['name']) ?>">
                                    </div>
                                    <div class="product-info">
                                        <h6 class="mb-1"><?= htmlspecialchars($product['name']) ?></h6>
                                        <span class="price"><?= number_format($product['price'], 2) ?> EGP</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/myorders_admin.js"></script>

<?php include('./assets/html/footer.php') ?>