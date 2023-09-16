<?php 

function load_assets(){
    wp_enqueue_style("font","//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i", array(), "1.0", "all");
    wp_enqueue_style( "bootstrapcss", '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), "1.1", 'all');
    wp_enqueue_style( "maincss", get_theme_file_uri() . '/build/index.css', array(), '1.0.2', 'all' );
    wp_enqueue_style( "mainstylecss", get_theme_file_uri() . '/build/style-index.css', array(), '1.0.3', 'all' );

    wp_enqueue_script( "university_scripts", get_theme_file_uri() . '/build/index.js', array('jquery'), '1.02', true );
}
add_action("wp_enqueue_scripts","load_assets");


function add_menu() {
    add_theme_support( 'menus' );
    register_nav_menus( array( 
        'themeLocationOne' => 'Footer Menu One',
        'themeLocationTwo' => 'Footer Menu Two'
    ) );
}

//Thêm menu vào wordpress -> footer 
add_action("init","add_menu");



//Giới hạn ký tự muốn hiển thị của hàm excerpt 
function wpdocs_custom_excerpt_length( $length ) {
	return 25;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length' );


//Tạo mới một cái main query 
function university_create_query($query) {
    //Áp dụng custom query cho thằng Archive Programmes
    if(!is_admin() AND is_post_type_archive( 'programmes' ) AND $query->is_main_query()) {
        $query->set('orderby','title');
        $query->set('order','ASC');
        $query->set('posts_per_page', -1);
    }
    //Áp dụng custom query cho thằng Archive Events 
    if(!is_admin() AND is_post_type_archive( 'event' ) AND $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('post_type','event');
        $query->set('posts_per_page', 2);
        $query->set('meta_key','events_date');
        $query->set('orderby','meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query',array(
                array( 
                  "key" => 'events_date',
                  "compare" => '>=',
                  "value" => $today,
                  "type" => 'numeric' 
                )
        ) );
    }

}
add_action('pre_get_posts','university_create_query');