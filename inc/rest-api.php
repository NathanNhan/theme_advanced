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
                "authorName" => get_the_author(),
                "image" => get_the_post_thumbnail_url(0,'professorLandscape')
            ));
        }

        if(get_post_type() == "programmes" ) {
            array_push($new_array["programmes"], array( 
                "title" => get_the_title(),
                "permalink" => get_the_permalink(),
                "postType" => get_post_type(),
                "authorName" => get_the_author(),
                "ID" => get_the_ID()
            ));
        }

        if(get_post_type() == "event") {
            $eventsDate = new DateTime(get_field('events_date'));
            // trả về description của sự kiện
           
            if(has_excerpt()) {
                $description = the_excerpt();
            } else {
                $description = wp_trim_words(get_the_content(), 18);
            }
            array_push($new_array["events"], array( 
                "title" => get_the_title(),
                "permalink" => get_the_permalink(),
                "postType" => get_post_type(),
                "authorName" => get_the_author(),
                "day" => $eventsDate->format('d'), 
                "month" => $eventsDate->format('M'),
                "description" => $description
            ));
        }
    }

    //Tìm kiếm thầy/cô theo môn học bằng custom query 
    $danhSachMonHoc = $new_array['programmes'];
    foreach ($danhSachMonHoc as $item) {
        $query = array(
            array( 
                'key' => 'related_programs', 
                'compare' => 'LIKE',
                'value' => '"' . $item['ID'] . '"'
            )
        );
        # code...
    }
    $relatedPrograms = new WP_Query(
        array( 
            'post_type' => "professors",
            'relation' => 'OR',
            'meta_query' => $query
        )
    );
     //Lặp qua danh sách của các thầy cô dạy môn tương ứng
     while($relatedPrograms->have_posts()) {
        $relatedPrograms->the_post();
        array_push($new_array["professors"], array( 
                "title" => get_the_title(),
                "permalink" => get_the_permalink(),
                "postType" => get_post_type(),
                "authorName" => get_the_author(),
                "image" => get_the_post_thumbnail_url(0,'professorLandscape')
        ));

     }
    return  $new_array;
}
// API -> CRUD : Create -> method = POST 
// READ -> method = GET 
// UPDATE -> method = POST/PATCH 
// DELETE -> method = DELETE