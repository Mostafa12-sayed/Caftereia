$(document).ready(function() {
    $(".view-orders").click(function() {
        var orderId = $(this).data("id");
        var detailsRow = $("#order-" + orderId);
        var detailsDiv = $("#order-items-" + orderId);

        if (detailsRow.is(":visible")) {
            detailsRow.hide();
        } else {
            $.ajax({
                url: "get_order_details.php",
                type: "GET",
                data: { order_id: orderId },
                success: function(response) {
                    detailsDiv.html(response);
                    detailsRow.show();
                }
            });
        }
    });
});