<?php 

add_action( 'rest_api_init', function () {
  register_rest_route( 'university/v1', 'universities', array(
    'methods' => 'GET',
    'callback' => 'getResults',
  ) );
} );

function getResults($data) {
    // print_r($data);
    $university = new WP_Query(
        array( 
            'post_type' => 'post',
            's' => $data['term']
        )
    );
    $new_array = [];
    while($university->have_posts()) {
        $university->the_post();
        array_push($new_array, array( 
            "title" => get_the_title(),
            "permalink" => get_the_permalink()
        ));
    }
    return  $new_array;
}
// API -> CRUD : Create -> method = POST 
// READ -> method = GET 
// UPDATE -> method = POST/PATCH 
// DELETE -> method = DELETE