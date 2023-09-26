<?php

  get_header();

  while(have_posts()) {
    the_post();
	  pageBanner([
		  'title' =>  get_the_title(),
		  'subtitle' => 'Learn how the school of your dreams got started.'
	  ]);?>
    <div class="container container--narrow page-section">
      <?php
      $parent = wp_get_post_parent_id(get_the_ID());
      if($parent){ ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
          <p>
            <a class="metabox__blog-home-link" href="<?php echo get_permalink($parent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($parent); ?></a> <span class="metabox__main"><?php the_title(); ?></span>
          </p>
        </div>
        <?php } ?>

      <?php
      $arr = get_pages([
          'child_of' => get_the_ID()
      ]);
      if($parent or $arr){
        ?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="<?php echo get_permalink($parent); ?>"><?php echo get_the_title($parent); ?></a></h2>
        <ul class="min-list">
          <?php
          $childOf = $parent ? $parent : get_the_ID();
          wp_list_pages([
              'title_li' => NULL,
              'child_of' => $childOf,
              'sort_column' => 'menu_order'
          ]) ?>
        </ul>
      </div>
      <?php } ?>
      <div class="generic-content">
       <?php the_content(); ?>
      </div>
    </div>




  <?php }
  get_footer();

?>