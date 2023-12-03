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
                        <?php 
                            $likeCount = new WP_Query(
                              array( 
                                'post_type' => 'like',
                                'meta_query' => array( 
                                  array( 
                                    'meta_key' => 'professors_id', 
                                    'compare' => '=', 
                                    'value' => get_the_ID()
                                  )
                                )
                              )
                            );

                            //Xử lý like icon 
                            $status = "no";

                            $existsLike = new WP_Query(
                              array( 
                                'author' => get_current_user_id(),
                                'post_type' => 'like',
                                'meta_query' => array( 
                                  array( 
                                    'meta_key' => 'professors_id', 
                                    'compare' => '=', 
                                    'value' => get_the_ID()
                                  )
                                )
                              )
                            );

                            if($existsLike->found_posts) {
                              $status = "yes";
                            }
                             

                        ?>
                          <span class="like-box" data-exists="<?php echo $status; ?>" data-professorID="<?php the_ID(); ?>">
                            <i class="fa fa-heart-o" aria-hidden="true"></i>
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            <span class="like-count"><?php echo $likeCount->found_posts; ?></span>
                          </span>
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