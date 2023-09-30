<?php 
// header
get_header();
getBanner(array( 
  "title" => get_the_archive_title(),
  "subtitle" => get_the_archive_description()
));
?>
<!-- Layout body -->
   <div class="container container--narrow page-section">
      <?php
           while(have_posts()) {
            the_post();
            //Hiển thị thông tin bài viết
            ?> 
                    <div class="post-item">
                        <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        
                        <div class="metabox">
                            <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></p>
                        </div>

                        <div class="generic-content">
                            <?php the_excerpt(); ?>
                            <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
                       </div>

    </div>

            <?php
           }
          
      ?>


   </div>





<?php 
// footer
get_footer();




?>