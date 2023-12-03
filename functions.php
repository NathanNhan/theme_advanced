<?php 
// import custom rest api của tính năng search
require get_theme_file_path( '/inc/rest-api.php' );
// import custom rest api của tính năng like
require get_theme_file_path('/inc/rest-like.php');
// Thêm field vào rest api của Wordpress 
function registerField(){
    register_rest_field( 'post', 'authorName', array( 
        'get_callback' => function () {return get_author_name();}
    ) );
    //Bài tập cho custom rest api => post type = page
    register_rest_field( 'page', 'authorName', array( 
        'get_callback' => function () {return get_author_name();}
    ) ); 
    
}
add_action( 'rest_api_init', 'registerField' );
function load_assets(){
    wp_enqueue_style("font","//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i", array(), "1.0", "all");
    wp_enqueue_style( "bootstrapcss", '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), "1.1", 'all');
    wp_enqueue_style( "maincss", get_theme_file_uri() . '/build/index.css', array(), '1.0.2', 'all' );
    wp_enqueue_style( "mainstylecss", get_theme_file_uri() . '/build/style-index.css', array(), '1.0.3', 'all' );

    wp_enqueue_script( "university_scripts", get_theme_file_uri() . '/build/index.js', array('jquery'), '1.02', true );
    wp_localize_script( 'university_scripts', 'universityData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce( 'wp_none' ),
    ) );
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


///Xử lý hình ảnh cho post type = professor 


add_action( 'after_setup_theme', 'wpdocs_theme_setup' );
function wpdocs_theme_setup() {
	// add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrail', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);
}


// Khai báo hàm getBanner 
function getBanner ($nhanthamso = NULL) {
    if(!isset($nhanthamso["title"])) {
       $nhanthamso["title"] = get_the_title();
    }
    if(!isset($nhanthamso["subtitle"])) {
       $nhanthamso["subtitle"] = get_field("page_banner_subtittle");
    }
    if(!isset($nhanthamso["photo"])) {
       if(get_field("page_banner_background_image")) {
        $nhanthamso["photo"] = get_field("page_banner_background_image")['sizes']['pageBanner'];
       } else {
        $nhanthamso["photo"] = get_theme_file_uri( '/images/ocean.jpg' );
       }
    }
    ?> 
     <div class="page-banner">
            
            <div class="page-banner__bg-image" style="background-image: url(<?php echo $nhanthamso["photo"]; ?>);">
            </div>
            <div class="page-banner__content container container--narrow">
              <h1 class="page-banner__title"><?php echo $nhanthamso["title"]; ?></h1>
              <div class="page-banner__intro">
                <!-- <p><?php the_field('page_banner_subtittle'); ?></p> -->
                <p><?php echo $nhanthamso["subtitle"]; ?></p>
              </div>
            </div>  
          </div>
    <?php 
}

// Redirect homepage when guest login 
add_action('admin_init','redirectHomePage');

function redirectHomePage() {
    $guests = wp_get_current_user();
    if($guests->roles[0] == 'subscriber') {
        wp_redirect( site_url( '/') );
        exit;
    }
}

//Ẩn thanh topbar
add_action('wp_loaded','noAdminBar');

function noAdminBar() {
    $guests = wp_get_current_user();
    if($guests->roles[0] == 'subscriber') {
        show_admin_bar( false );
    }
}

// Chuyển về trang chủ khi ng dùng click vào biểu tượng Wordpress của form login 
add_filter('login_headerurl','chuyenTrangHomePage');
function chuyenTrangHomePage() {
    return esc_url(site_url('/'));
}

//Load css cho trang login 
add_action('login_enqueue_scripts','login_loading_assets');
function login_loading_assets() {
    wp_enqueue_style("font","//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i", array(), "1.0", "all");
    wp_enqueue_style( "bootstrapcss", '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), "1.1", 'all');
    wp_enqueue_style( "maincss", get_theme_file_uri() . '/build/index.css', array(), '1.0.2', 'all' );
    wp_enqueue_style( "mainstylecss", get_theme_file_uri() . '/build/style-index.css', array(), '1.0.3', 'all' );
}


//Thay đổi tiêu đề cho trang login  
function my_login_logo_url_title() {
    return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );