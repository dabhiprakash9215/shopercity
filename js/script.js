$(document).ready(function(){
    $("#registerForm").submit(function (event) {
        // Prevent default form submission
        event.preventDefault();
        alert('submit')
        // Get form data
        var formData = $(this).serialize();
        console.log(formData);
        // Send AJAX request
        $.ajax({
            type: "POST",
            url: "submit.php",
            data: formData,
            success: function (response) {
                alert(response); // Display response from PHP script
                // You can also redirect the user to another page if needed
                // window.location.href = "success.html";
            }
        });
    });
    function signUp() {
        event.preventDefault();
    }
    //wishlist add and remove 
    $(".btn-product-icon.btn-wishlist.add-wishlist").click(function(){
        var vendor_id = $(this).attr("data-id");
        wishlist(vendor_id,'add');
        $('.btn-product-icon.btn-wishlist.add-wishlist').removeClass("add-wishlist");
        $('.btn-product-icon.btn-wishlist').addClass("remove-wishlist");
    });
    $(".btn-product-icon.btn-wishlist.remove-wishlist").click(function(){
        var vendor_id = $(this).attr("data-id");
        wishlist(vendor_id, 'delete');
        $('.btn-product-icon.btn-wishlist').removeClass("remove-wishlist");  
        $('.btn-product-icon.btn-wishlist').addClass("add-wishlist");  
    })
    

    function wishlist(id,action){
        $.ajax({
            url: 'db/wishlist_db.php',
            method: 'POST',
            data: {
                action: action,
                vendor_id:id
            },
            success: function(response){
                loadVendors();
            }
        });
    }
});
