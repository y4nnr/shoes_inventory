$(document).ready(function () {
    $('#shoesTable').DataTable({
        responsive: true,
        paging: true,
        ordering: true,
        info: true,
        searching: true,
    });

    // Prevent row click when clicking on specific elements (StockX, GOAT, and Picture)
    $(document).on("click", ".stockx-button, .goat-button, .shoe-thumbnail", function (event) {
        event.stopPropagation();
    });

    // Click event for opening shoe details modal
    $(document).on("click", ".shoe-row", function (event) {
        if (!$(event.target).hasClass("stockx-button") &&
            !$(event.target).hasClass("goat-button") &&
            !$(event.target).hasClass("shoe-thumbnail")) {

            var shoeID = $(this).data("shoeid");

            $.ajax({
                url: "get_shoe_profile.php",
                type: "GET",
                data: { id: shoeID },
                success: function (data) {
                    $("#shoeDetails").html(data);
                    $("#shoeModal").css({ "opacity": "1", "visibility": "visible" }).fadeIn();
                },
                error: function () {
                    $("#shoeDetails").html("<p>Error loading shoe details.</p>");
                    $("#shoeModal").css({ "opacity": "1", "visibility": "visible" }).fadeIn();
                }
            });
        }
    });

    // Clicking on the picture should open the image modal
    $(document).on("click", ".shoe-thumbnail", function () {
        var imgSrc = $(this).data("fullsize");
        $("#imageModal img").attr("src", imgSrc);
        $("#imageModal").css({ "opacity": "1", "visibility": "visible" }).fadeIn();
    });

    // Close the modals
    $(document).on("click", ".close, #shoeModal, #imageModal", function (event) {
        if ($(event.target).is("#shoeModal") || $(event.target).is("#imageModal") || $(event.target).hasClass("close")) {
            $("#shoeModal, #imageModal").fadeOut(function () {
                $("#shoeDetails").empty();
                $("#imageModal img").attr("src", "");
            });
        }
    });

    // Hide modals on page load to prevent flickering
    $("#shoeModal, #imageModal").hide();
});
