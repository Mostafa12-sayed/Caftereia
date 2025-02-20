<?php
session_start();
require_once 'orders_functions.php';


if (!isset($_SESSION['login']) && $_SESSION['login'] != true && $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}
?>




<?php include('./assets/html/header.php') ?>

<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-4">
                    <h2>Order <b>Details</b></h2>
                </div>
                <!-- <div class="col-sm-8">
                    <button class="btn btn-primary" id="refreshButton"><i class="fa-solid fa-rotate fs-13"></i> <span>Refresh List</span></button>
                </div> -->
            </div>
        </div>
        <div class="table-filter">
            <div class="row">
                <div class="d-flex justify-content-between " id=filter>
                    <div>
                        <button type="button" onclick="filterOrders()" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        <div class="filter-group">
                            <input type="text" id="customerName" class="form-control" placeholder="Enter Customer name">
                        </div>
                    </div>
                    <div>
                        <div class="filter-group ml-3">

                            <select class="form-control">
                                <option value="" disabled selected>Select Status</option>
                                <option>Any</option>
                                <option>Delivered</option>
                                <option>Completed</option>
                                <option>Pending</option>
                            </select>
                        </div>
                        <span class="filter-icon "><i class="fa fa-filter"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-aria">
            <table class="table table-striped table-hover orders-table" id="myTable">
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
                            <td style="cursor: pointer;" onclick="toggleDetails(<?php echo $order['id']; ?>)">
                                <?php echo ($order['user_name']); ?>
                            </td>
                            <td> <?php echo ($order['date']); ?> </td>

                            <!-- الحالة داخل <td> مع <span> بداخلها -->
                            <td>
                                <span class="status 
                                <?php if ($order['status'] == 'delivered') {
                                    echo "text-blue";
                                } else if ($order['status'] == 'completed') {
                                    echo  'text-success';
                                } else {
                                    echo 'text-warning';
                                } ?>"
                                    id="status-<?php echo $order['id']; ?>">
                                    <?php echo ($order['status']); ?>
                                </span>
                            </td>

                            <td><?php echo ($order['room']); ?></td>
                            <td>$ <?php echo number_format($order['total_price'], 2); ?></td>
                            <td width="150">
                                <a href="#" onclick="changeStatus(<?php echo $order['id']; ?>, 'completed')"
                                    class="view success" title="Mark as Completed" data-toggle="tooltip">
                                    <i class="fa-solid fa-check"></i>
                                </a>
                                <a href="#" onclick="changeStatus(<?php echo $order['id']; ?>, 'pending')"
                                    class="view pending" title="Mark as Pending" data-toggle="tooltip">
                                    <i class="fa-solid fa-hourglass"></i>
                                </a>
                                <a href="#" onclick="changeStatus(<?php echo $order['id']; ?>, 'delivered')"
                                    class="view deliver" title="Mark as Delivered" data-toggle="tooltip">
                                    <i class="fa-solid fa-truck"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>

            </table>
        </div>

    </div>
</div>




<script>
    function changeStatus(id, status) {
        console.log(`Changing status for Order ID: ${id}, New Status: ${status}`);

        const url = `orders_functions.php?id=${id}&status=${status}`;

        fetch(url)
            .then(response => response.text()) // احصل على الاستجابة كنص
            .then(rawResponse => {
                console.log('Raw Response:', rawResponse);
                try {
                    const data = JSON.parse(rawResponse); // تحليل الاستجابة إلى JSON

                    if (data.status === 'success') {
                        const row = document.getElementById(`row-${id}`);
                        if (!row) {
                            console.error(`Row with ID row-${id} not found.`);
                            return;
                        }

                        const statusCell = row.querySelector('.status');
                        if (!statusCell) {
                            console.error(`Status cell not found for row-${id}`);
                            return;
                        }

                        // إزالة جميع الكلاسات السابقة
                        statusCell.classList.remove('text-warning', 'text-success', 'text-danger', 'text-blue');

                        // تحديد اللون الجديد بناءً على الحالة
                        let newClass = 'text-warning'; // افتراضيًا
                        if (data.new_status === 'completed') {
                            newClass = 'text-success';
                        } else if (data.new_status === 'delivered') {
                            newClass = 'text-blue';
                        } else if (data.new_status === 'canceled') {
                            newClass = 'text-danger';
                        }

                        // إضافة الكلاس الجديد وتحديث النص
                        statusCell.classList.add(newClass);
                        statusCell.textContent = data.new_status;

                        console.log(`Status updated successfully for Order ID: ${id}`);
                    } else {
                        console.error('Error from server:', data.message || 'Unknown error');
                        alert('Error changing status');
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    console.error('Raw Response:', rawResponse);
                    alert('Invalid server response.');
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

    function filterOrders() {
        var customerName = $("#customerName").val();
        // console.log(customerName);
        // console.log("awgawgaw");

        $.ajax({
            url: "orders_functions.php",
            method: "GET",
            data: {
                customer_name: customerName
            },
            success: function(response) {
                $("table tbody").html('');

                // Append new filtered rows
                if (response.length > 0) {
                    response.forEach(function(order) {
                        var row = `
                                <tr id="row-${order.id}">
                                    <td>${order.id}</td>
                                    <td style="cursor: pointer;" onclick="toggleDetails(${order.id})">${order.name}</td>
                                    <td>${order.date}</td>
                                    <td><span class="status ${getStatusClass(order.status)}" id="status-${order.id}">${order.status}</span></td>
                                    <td>${order.room}</td>
                                    <td>$ ${parseFloat(order.total_price).toFixed(2)}</td>
                                    <td width="150">
                                        <a href="#" onclick="changeStatus(${order.id}, 'completed')" class="view success" title="Mark as Completed" data-toggle="tooltip"><i class="fa-solid fa-check"></i></a>
                                        <a href="#" onclick="changeStatus(${order.id}, 'pending')" class="view pending" title="Mark as Pending" data-toggle="tooltip"><i class="fa-solid fa-hourglass"></i></a>
                                        <a href="#" onclick="changeStatus(${order.id}, 'delivered')" class="view deliver" title="Mark as Delivered" data-toggle="tooltip"><i class="fa-solid fa-truck"></i></a>
                                    </td>
                                </tr>
        `;
                        $("table tbody").append(row);
                    });
                } else {
                    $("table tbody").append("<tr style='text-align:center;'><td colspan='7'>No orders found.</td></tr>");
                }

            }
        });
    }

    function getStatusClass($status) {
        if ($status == 'delivered') return 'text-blue';
        else if ($status == 'completed') return 'text-success';
        else return 'text-warning';
    }
</script>
<?php include('./assets/html/footer.php') ?>