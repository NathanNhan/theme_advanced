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

function createLike($data) {
   $professor = sanitize_text_field($data['professorID']);

   return wp_insert_post(array(
        'post_type' => 'like',
        'post_status' => 'publish',
        'post_title' => '2nd PHP Test',
        'meta_input' => array(
          'professors_id' => $professor
        )
  ));
}


function deleteLike() {
   return "Kết quả trả về là delete like";
}


// domain/wp-json/namespace(university/v1)/posts 
?>