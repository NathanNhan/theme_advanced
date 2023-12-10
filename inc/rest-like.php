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
   $professor = sanitize_text_field($data['professorId']);

   if(is_user_logged_in()) {
    $userLiked = new WP_Query(
      array( 
        'post_type' => 'like',
        'author'    => get_current_user_id(),
        'meta_query' => array( 
          'meta_key' => 'professors_id',
          'compare' => '=',
          'meta_value' => $professor // lấy dc ID của giảng viên mà user đang xem hiện tại
         )
      )
    );
    if($userLiked->found_posts == 0 && get_post_type( $professor ) == 'professors') {
      return wp_insert_post(array(
         'post_type' => 'like',
         'post_status' => 'publish',
         'post_title' => '2nd PHP Test',
         'meta_input' => array(
           'professors_id_' => $professor
         )
      ));
    } else {
      die('Like khong hop le');
    }
      
   } else {
    die('Only user login must to be create like');
   }

  
    //tao like
    
}


function deleteLike($data) {
   $likeID = sanitize_text_field($data["like"]);
  //  echo $likeID;
   wp_delete_post( $likeID, true );
   
  // wp_delete_post($likeID, true);
   
}


// domain/wp-json/namespace(university/v1)/posts 
?>