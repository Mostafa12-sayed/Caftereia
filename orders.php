<?php
session_start();


if (!isset($_SESSION['login']) && $_SESSION['login'] != true && $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}
require_once 'orders_functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Create Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/myorders_admin.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="assets/css/orders.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="assets/images/logo.jpg" class="Cafeteria-Logo" alt="Cafeteria Logo" class="rounded-circle">
            </a>

            <!-- Navbar Toggle Button for Mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapsible Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="allUsers.php">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="myorders_admin.php">Manual Order</a></li>
                    <li class="nav-item"><a class="nav-link" href="checks.php">Checks</a></li>
                    <li class="nav-item"><a class="nav-link active fw-bold" href="orders.php">Orders</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <div class="admin-profile d-flex align-items-center" id="profileToggle">
                        <img src="assets/images/profile_img/<?= isset($_SESSION['profile_img']) ? $_SESSION['profile_img'] : 'default.jpg' ?>" class="rounded-circle" height="70">
                        <span class="ms-2 fw-bold"><?= $_SESSION['name'] ?></span>
                        <div class="dropdown-menu" id="dropdownMenu">
                            <a href="#">Profile</a>
                            <a href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </nav>




    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-4">
                        <h2>Order <b>Details</b></h2>
                    </div>
                    <div class="col-sm-8">
                        <a href="#" class="btn btn-primary"><i class="material-icons">&#xE863;</i> <span>Refresh List</span></a>
                    </div>
                </div>
            </div>
            <div class="table-filter">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="show-entries">
                            <span>Show</span>
                            <select class="form-control">
                                <option>5</option>
                                <option>10</option>
                                <option>15</option>
                                <option>20</option>
                            </select>
                            <span>entries</span>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <button type="button" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        <div class="filter-group">
                            <label>Name</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="filter-group">
                            <label>Status</label>
                            <select class="form-control">
                                <option>Any</option>
                                <option>Delivered</option>
                                <option>Completed</option>
                                <option>Pending</option>
                            </select>
                        </div>
                        <span class="filter-icon"><i class="fa fa-filter"></i></span>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover" id="myTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer name</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Room</th>
                        <th>Net Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) { ?>
                        <tr id="row-<?php echo $order['id']; ?>">
                            <td><?php echo $order['id']; ?></td>
                            <td style="cursor: pointer;" onclick="toggleDetails(<?php echo $order['id']; ?>)"> <?php echo $order['user_name']; ?> </td>
                            <td> <?php echo $order['date']; ?> </td>
                            <td><span class="status <?php if ($order['status'] == 'delivered') echo 'text-success';
                                                    else if ($order['status'] == 'completed') echo 'text-success';
                                                    else echo 'text-warning'; ?>">&bull;</span>
                                <?php echo $order['status']; ?> </td>
                            <td><?php echo $order['room']; ?></td>
                            <td>$ <?php echo $order['total_price']; ?></td>
                            <td><a href="#" onclick="
                            changeSatatus(<?php echo $order['id']; ?> , '<?php echo $order['status']; ?>')"
                                    class="view" title="View Details" data-toggle="tooltip"><i class="material-icons">&#xE5C8;</i></a></td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
            <div class="clearfix">
                <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                <ul class="pagination">
                    <li class="page-item disabled"><a href="#">Previous</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item"><a href="#" class="page-link">3</a></li>
                    <li class="page-item active"><a href="#" class="page-link">4</a></li>
                    <li class="page-item"><a href="#" class="page-link">5</a></li>
                    <li class="page-item"><a href="#" class="page-link">6</a></li>
                    <li class="page-item"><a href="#" class="page-link">7</a></li>
                    <li class="page-item"><a href="#" class="page-link">Next</a></li>
                </ul>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/orders_table.js"></script>
</body>
<script>
    function changeSatatus(id, status) {
        console.log(id, status);
        var status = status;
        const url = `orders_functions.php?id=${id}&status=${status}`;

        fetch(url)
            .then(response => response.text()) // Use text() instead of json() to check the raw response
            .then(rawResponse => {
                try {
                    const data = JSON.parse(rawResponse); // Manually parse JSON
                    if (data.status === 'success') {
                        var newStatus = (data.new_status == 'delivered' || data.newStatus == 'completed' ? 'text-success' : 'text-warning');
                        const row = document.getElementById(`row-${id}`);
                        const statusCell = row.querySelector('.status');
                        statusCell.classList.remove('text-warning');
                        statusCell.classList.add(`text-${data.new_status}`);
                        statusCell.textContent = data.new_status;
                        statusCell.textContent = data.newStatus;
                    } else {
                        alert('Error changing status');
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            })
            .catch(error => console.error('Error changing status:', error));

    }

    function toggleDetails(orderId) {
        const existingRow = document.getElementById(`details-${orderId}`);

        if (existingRow) {
            existingRow.remove(); // Remove row if it already exists
        } else {
            // Make an AJAX request to fetch order details
            fetch(`get_order_products.php?order_id=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    // Create a new row
                    const mainRow = document.getElementById(`row-${orderId}`);
                    const newRow = document.createElement('tr');
                    newRow.id = `details-${orderId}`;
                    const newCell = document.createElement('td');
                    newCell.colSpan = 7; // Merge all columns




                    // Generate content with order products
                    let content = `<div class="order-details d-flex justify-content-center  align-items-center  ">`;
                    data.forEach(product => {
                        content += `
                            <div class="order-details-content position-relative d-flex flex-column justify-content-center align-items-center">
                                <img src="assets/images/products/${product.image}" width="60" height="60" alt="Product Image">
                                <span class="price">$${product.price}</span>
                                <span id="name" class="text-muted fw-bold">${product.name}</span>
                                <span id="quantity" class="text-muted fw-bold">${product.quantity}</span>
                            </div>
                        `;
                    });
                    content += `</div>`;

                    newCell.innerHTML = content;
                    newCell.style.backgroundColor = '#f9f9f9';
                    newCell.style.padding = '10px';
                    newRow.appendChild(newCell);

                    // Insert the new row after the clicked row
                    mainRow.parentNode.insertBefore(newRow, mainRow.nextSibling);
                })
                .catch(error => console.error('Error fetching order details:', error));
        }
    }

    // function toggleDetails(orderId) {
    // const existingRow = document.getElementById(`details-${orderId}`);

    // if (existingRow) {
    //     // If the row already exists, toggle its visibility
    //     existingRow.remove();
    // } else {
    //     // Create a new row with merged columns
    //     const mainRow = document.getElementById(`row-${orderId}`);
    //     const newRow = document.createElement('tr');
    //     newRow.id = `details-${orderId}`;
    //     const newCell = document.createElement('td');
    //     newCell.colSpan = 7; // Merge all columns
    //     newCell.innerHTML = `   
    //                         <div class="spinner-border text-primary text-center" role="status" id="spinner">
    //                         </div>
    //                        `;
    //     newCell.style.backgroundColor = '#f9f9f9';
    //     newCell.style.padding = '10px';
    //     newRow.appendChild(newCell);



    //     // Insert the new row after the clicked row
    //     mainRow.parentNode.insertBefore(newRow, mainRow.nextSibling);





    // }
    // }
</script>

</html>