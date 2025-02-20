$(document).ready(function () {
  $(".view-orders").click(function () {
    var orderId = $(this).data("id");
    var detailsRow = $("#order-" + orderId);
    var detailsDiv = $("#order-items-" + orderId);
    var selectedProductsDiv = $("#selected-products");

    if (detailsRow.is(":visible")) {
      detailsRow.hide();
    } else {
      $.ajax({
        url: "orderDetails.php",
        type: "GET",
        data: { order_id: orderId },
        success: function (response) {
          detailsDiv.html(response);
          detailsRow.show();
          $.ajax({
            url: "selectedProducts.php",
            type: "GET",
            data: { order_id: orderId },
            success: function (productResponse) {
              selectedProductsDiv.html(productResponse);
            },
          });
        },
      });
    }
  });
});

// console.log("hiiii")
