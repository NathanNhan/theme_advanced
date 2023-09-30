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
      <ul class="link-list min-list">
      <?php
           while(have_posts()) {
            the_post();
            //Hiển thị thông tin bài viết
            ?> 
               <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php
           }


          
      ?>
     
     </ul>

   </div>





<?php 
// footer
get_footer();




?>