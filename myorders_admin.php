<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Create Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/images/logo.png" alt="Cafeteria Logo" height="40">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="manual_order.php">Manual Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="checks.php">Checks</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <div class="search-container">
                        <input type="text" class="form-control search-input" id="searchInput" placeholder="Search products...">
                        <i class="fas fa-search search-icon"></i>
                    </div>
                    <div class="admin-profile">
                        <img src="assets/images/admin-avatar.png" class="rounded-circle" width="40" height="40">
                        <span class="ms-2 fw-bold">admin</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <div class="row g-4">
            <!-- Order Form Section -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Create Order</h5>
                    </div>
                    <div class="card-body">
                        <form id="orderForm">
                            <div class="selected-products mb-4">
                                <div class="d-flex align-items-center p-2 border rounded mb-2">
                                    <img src="assets/images/products/tea.jpg" class="product-thumbnail">
                                    <div class="ms-2 flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="fw-bold">Tea</label>
                                            <span class="text-primary">EGP 25</span>
                                        </div>
                                        <div class="d-flex align-items-center mt-1">
                                            <div class="input-group input-group-sm" style="width: 100px;">
                                                <button type="button" class="btn btn-outline-secondary btn-decrease">-</button>
                                                <input type="number" name="tea_qty" class="form-control text-center" value="5">
                                                <button type="button" class="btn btn-outline-secondary btn-increase">+</button>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger ms-2">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center p-2 border rounded mb-2">
                                    <img src="assets/images/products/cola.jpg" class="product-thumbnail">
                                    <div class="ms-2 flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="fw-bold">Cola</label>
                                            <span class="text-primary">EGP 30</span>
                                        </div>
                                        <div class="d-flex align-items-center mt-1">
                                            <div class="input-group input-group-sm" style="width: 100px;">
                                                <button type="button" class="btn btn-outline-secondary btn-decrease">-</button>
                                                <input type="number" name="cola_qty" class="form-control text-center" value="3">
                                                <button type="button" class="btn btn-outline-secondary btn-increase">+</button>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger ms-2">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" name="notes" rows="2" placeholder="Add special instructions...">1 Tea Extra Sugar</textarea>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label">Room</label>
                                <select class="form-select" name="room">
                                    <option value="">Select Room</option>
                                    <option value="room1">Room 1</option>
                                    <option value="room2">Room 2</option>
                                    <option value="room3">Room 3</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <div class="order-total">
                                    <span class="text-muted">Total:</span>
                                    <span class="h5 mb-0 ms-2">EGP 55</span>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-2"></i>Confirm Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Grid Section -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Add to user</h5>
                            <select class="form-select" id="userSelect" style="width: auto;">
                                <option>Islam Askar</option>
                                <option>Other Users...</option>
                            </select>
                        </div>

                        <div class="row row-cols-2 row-cols-md-4 g-4">
                            <!-- Tea Products -->
                            <div class="col">
                                <div class="product-card">
                                    <div class="product-image-container">
                                        <img src="assets/images/products/tea-1.jpg" class="product-image">
                                    </div>
                                    <div class="product-info">
                                        <h6 class="mb-1">Tea</h6>
                                        <span class="price">5 LE</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="product-card">
                                    <div class="product-image-container">
                                        <img src="assets/images/products/tea-2.jpg" class="product-image">
                                    </div>
                                    <div class="product-info">
                                        <h6 class="mb-1">Tea Extra Sugar</h6>
                                        <span class="price">6 LE</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="product-card">
                                    <div class="product-image-container">
                                        <img src="assets/images/products/coffee.jpg" class="product-image">
                                    </div>
                                    <div class="product-info">
                                        <h6 class="mb-1">Coffee</h6>
                                        <span class="price">8 LE</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="product-card">
                                    <div class="product-image-container">
                                        <img src="assets/images/products/nescafe.jpg" class="product-image">
                                    </div>
                                    <div class="product-info">
                                        <h6 class="mb-1">Nescafe</h6>
                                        <span class="price">9 LE</span>
                                    </div>
                                </div>
                            </div>

                            <!-- More products... -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="assets/js/admin-order.js"></script> -->
</body>
</html>