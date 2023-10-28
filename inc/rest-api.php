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
            'post_type' => ["post","page","professors","event","programmes"],
            's' => $data['term']
        )
    );
    $new_array = [
        "general_info" => [],
        "professors" => [],
        "programmes" => [],
        "events" => []
    ];
    while($university->have_posts()) {
        $university->the_post();
        // array_push($new_array, array( 
        //     "title" => get_the_title(),
        //     "permalink" => get_the_permalink()
        // ));
        if(get_post_type() == "post" OR get_post_type() == "page" ) {
            array_push($new_array["general_info"], array( 
                "title" => get_the_title(),
                "permalink" => get_the_permalink(),
                "postType" => get_post_type(),
                "authorName" => get_the_author()
            ));
        }

        if(get_post_type() == "professors") {
            array_push($new_array["professors"], array( 
                "title" => get_the_title(),
                "permalink" => get_the_permalink(),
                "postType" => get_post_type(),
                "authorName" => get_the_author()
            ));
        }

        if(get_post_type() == "programmes" ) {
            array_push($new_array["programmes"], array( 
                "title" => get_the_title(),
                "permalink" => get_the_permalink(),
                "postType" => get_post_type(),
                "authorName" => get_the_author()
            ));
        }

        if(get_post_type() == "event") {
            array_push($new_array["events"], array( 
                "title" => get_the_title(),
                "permalink" => get_the_permalink(),
                "postType" => get_post_type(),
                "authorName" => get_the_author()
            ));
        }
    }
    return  $new_array;
}
// API -> CRUD : Create -> method = POST 
// READ -> method = GET 
// UPDATE -> method = POST/PATCH 
// DELETE -> method = DELETE