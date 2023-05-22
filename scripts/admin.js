// Script for checking all the boxes when "Check All" box is checked
function checkAll() {
    var checkboxes = document.getElementsByName("category");
    var checkall = document.getElementById("checkAll");

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = checkall.checked;
    }
}

// Script for filtering products based on what checkboxes are checked
function filter() {
    // Get all checked boxes and add it to categories
    var categories = [];
    $.each($("input[name='category']:checked"), function() {
        categories.push($(this).val());
    });

    // Show all products if nothing is checked
    if (categories.length === 0) {
        $(".productsTable tbody tr").show();
    } else {
        // Show only checked categories
        $(".productsTable tbody tr").hide();
        $.each(categories, function(index, value) {
            $(".productsTable tbody tr:contains('" + value + "')").show();
        });
    }
}