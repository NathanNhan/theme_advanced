<?php 
add_action( 'rest_api_init', function () {
  register_rest_route( 'university/v2', 'manageLike', array(
    'methods' => 'POST',
    'callback' => 'createLike',
  ) );

   register_rest_route( 'university/v2', 'manageLike', array(
    'methods' => 'DELETE',
    'callback' => 'deleteLike',
  ) );
} );

function createLike() {
    return "Kết quả trả về là create like";
}


function deleteLike() {
   return "Kết quả trả về là delete like";
}


// domain/wp-json/namespace(university/v1)/posts 
?>