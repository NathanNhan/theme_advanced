<?php

  get_header();

  while(have_posts()) {
    the_post(); ?>
    
    <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
      <div class="page-banner__intro">
        <p>DONT FORGET TO REPLACE ME LATER</p>
      </div>
    </div>  
  </div>

  <div class="container container--narrow page-section">
    <?php
        $theParent = wp_get_post_parent_id(get_the_ID());
        if($theParent) {
        ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_the_permalink( $theParent ); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to About Us</a> <span class="metabox__main"><?php the_title(); ?></span></p>
        </div>
    <?php
        }
    
    ?>
    
    <!-- About us = 6 -> Our history = 12 
    wp_get_post_parent_id(12) -> 6 -> hiển thị thanh sidebar bên phải 
    if wp_get_post_parent_id(6) = 0 -> hiển thị thanh sidebar bên phải  -->

    <!-- Lấy các page con của page hiện tại -> kết quả trả về true -> page = page cha  -->
    <?php
      $layCacPageCon = get_pages(array( 
        'child_of' => get_the_ID()
      ));
      // Nếu như page hiện tại là page con (có ID page cha) hoặc page hiện tại là page cha (chứa các page con) 
      if($theParent OR $layCacPageCon) {
        ?>
        <div class="page-links">
          <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>"><?php echo get_the_title($theParent); ?></a></h2>
          <ul class="min-list">
            <!-- <li class="current_page_item"><a href="<?php echo site_url('/our-history'); ?>">Our History</a></li>
            <li><a href="<?php echo site_url('/our-goal'); ?>">Our Goals</a></li> -->
            <?php 
               if($theParent) {
                $idCuaPageCha = $theParent;
               } else {
                $idCuaPageCha = get_the_ID();
               }
               wp_list_pages( array( 
                'title_li' => NULL, 
                'child_of' => $idCuaPageCha
               ) );
            
            ?>
          </ul>
        </div>

        <?php 
         
      }
    
    ?>

    
   

    <div class="generic-content">
      <?php the_content(); ?>
    </div>

  </div>
    
  <?php }

  get_footer();

?>