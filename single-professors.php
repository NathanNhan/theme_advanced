<?php

  get_header();
  
  if(have_posts()) {
    while(have_posts()) {
      the_post();
      getBanner();
      ?>
           <div class="container container--narrow page-section">
                  <div class="generic-content">
                    <div class="row group">
                      <div class="one-third">
                          <!-- hÌNH ẢNH  -->
                          <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                      </div>
                      <div class="two-thirds">
                          <?php the_content(); ?>
                      </div>
                    </div>
                            
                  </div> 
                  
                  <?php
                     $relatedPrograms = get_field('related_programs');
                     //vòng lặp chương trình liên quan đến sự kiện
                     if($relatedPrograms) {
                      ?>
                            <hr class="section-break">  
                            <h3 class="headline headline--medium">
                            Related <?php echo get_the_title(); ?> Program
                            </h3>
                            <ul class="link-list min-list">
                            <?php 
                            foreach ($relatedPrograms as $program) {
                             ?>
                                 <li><a href="<?php echo get_the_permalink($program ); ?>"><?php echo get_the_title($program); ?></a></li> 
                             <?php 
                            }
                            ?>
                           </ul>
                      <?php 
                     }
                  
                  ?>
           </div>
      <?php
    }
  }
  

  get_footer();

?>