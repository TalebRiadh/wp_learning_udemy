<?php

get_header();

while(have_posts()) {
	the_post();
    pageBanner();
    ?>
	<div class="container container--narrow page-section">
		<div class="metabox metabox--position-up metabox--with-home-link">
			<p>
				<a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Programs </a>
				<span class="metabox__main"><?php the_title(); ?></span>
			</p>
		</div>
		<div class="generic-content">
			<?php the_content(); ?>
		</div>
                <?php
                $professor = new WP_Query([
	                'posts_per_page' => -1,
	                'post_type' => 'professor',
	                'orderby' => 'title',
	                'order' => 'ASC',
	                'meta_query' => [
		                [
			                'key' => 'related_programs',
			                'compare' => 'LIKE',
			                'value' => '"'. get_the_ID() . '"',
		                ]
	                ]
                ]);

                if($professor->have_posts()){
	                echo '<hr class="section-break">';
	                echo '<h2 class="headline headline--meduim">Related ' . get_the_title() . ' professors</h2>';
                    echo '<ul class="professor-cards">';
	                while($professor->have_posts()){
		                $professor->the_post();
		                ?>
                        <li class="professor-card__list-item">
                            <a class="professor-card" href="<?php the_permalink(); ?>">
                                <img class="professor-card__image" src="<?php the_post_thumbnail_url('professorLandScape'); ?>">
                                <span class="professor-card__name"><?php the_title(); ?></span>
                            </a>
                        </li>
		                <?php
	                }
                    echo '</ul>';
                }

        wp_reset_postdata();

        $today = date('Ymd');
        $events = new WP_Query([
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => [
                    [
                        'key' => 'event_date',
                        'compare' => '>=',
                        'value' => $today,
                        'type' => 'numeric'
                    ],
                    [
	                    'key' => 'related_programs',
	                    'compare' => 'LIKE',
	                    'value' => '"'. get_the_ID() . '"',
                    ]
            ]
        ]);
            if($events->have_posts()){
                echo '<hr class="section-break">';
	            echo '<h2 class="headline headline--meduim">Upcoming ' . get_the_title() . ' Events</h2>';
	            while($events->have_posts()){
		            $events->the_post();
		            ?>
                    <div class="event-summary">
                        <a class="event-summary__date t-center" href="<?php the_permalink(); ?>">
                        <span class="event-summary__month"><?php
	                        $eventDate = new DateTime(get_field('event_date'));
	                        echo $eventDate->format('M');
	                        ?></span>
                            <span class="event-summary__day"><?php echo $eventDate->format('d') ?></span>
                        </a>
                        <div class="event-summary__content">
                            <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                            <p><?php
					            if(has_excerpt()){
						            the_excerpt();
					            }else{
						            echo wp_trim_words(get_the_content(), 18);
					            }?><a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
                        </div>
                    </div>
		            <?php
	            }
            }
	            ?>


	</div>


<?php }

get_footer();

?>