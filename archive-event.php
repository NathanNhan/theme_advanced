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
            get_template_part("template-part/content", "event");
           }

           echo paginate_links();
          
      ?>
      <hr class="divider_break">
      <p>Looking for all Past Events. <a href="<?php echo site_url('/past-events'); ?>">Check out past events in here. </a></p>


   </div>





<?php 
// footer
get_footer();




?>