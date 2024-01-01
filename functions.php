<?php


function PageBanner($args = NULL){
	if (!isset($args['title'])) {
		$args['title'] = get_the_title();
	}
	if(!isset($args['subtitle'])) {
		$args['subtitle'] = get_field('page_banner_subtitle');
	}
	if(!isset($args['photo'])) {
		if(get_field('page_banner_background_image') && !is_archive() && !is_home()) {
			$args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
		}else{
			$args['photo'] = get_theme_file_uri('/images/ocean.jpg');
		}
	}
	?>
	<div class="page-banner">
		<div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo'] ?>);"></div>
		<div class="page-banner__content container container--narrow">
			<h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
			<div class="page-banner__intro">
				<p><?php echo $args['subtitle']; ?></p>
			</div>
		</div>
	</div>
<?php
}
function university_files() {
	//wp_enqueue_script('googleMap','//maps.googleapi.com/maps/api/js?key=AIzaSyBtMaabuibUdS8BCZ9pFs7kITTvZoQNlOE', null,'1.0', true);
	wp_enqueue_script('main-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css', []);
    wp_register_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js', ['popper', 'jquery'], false, true);
    wp_register_script('popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js', [], false, true);
    wp_deregister_script('jquery');
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', [], false, true);
    wp_enqueue_style('bootstrap');
    wp_enqueue_script('bootstrap');
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('university_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('university_extra_styles', get_theme_file_uri('/build/index.css'));
    wp_enqueue_script('main-js', get_theme_file_uri('/js/main.js'), array(), '1.0', true);

}

function university_features(){
    register_nav_menu('HeaderMenuLocation','Header Menu Location');
    add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_image_size('professorLandScape', 400, 260, true);
	add_image_size('professorPortrait', 480, 650, true);
	add_image_size('pageBanner', 1500, 350, true);
}


function university_adjust_queries($query){
	if(!is_admin() && is_post_type_archive('program') && $query->is_main_query()){

		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
		$query->set('posts_per_page', -1);
	}

	if(!is_admin() && is_post_type_archive('event') && $query->is_main_query()){
		$today = date('Ymd');
		$query->set('meta_key', 'event_date');
		$query->set('orderby', 'meta_value_num');
		$query->set('order', 'ASC');
		$query->set('meta_query', [
			[
				'key' => 'event_date',
				'compare' => '>=',
				'value' => $today,
				'type' => 'numeric'
			],
		]);
	}
}
function my_acf_google_map_api($api) {
    $api['key'] = 'AIzaSyBtMaabuibUdS8BCZ9pFs7kITTvZoQNlOE';
    return $api;
}

add_action('wp_enqueue_scripts', 'university_files');
add_action('after_setup_theme', 'university_features');
add_action('pre_get_posts', 'university_adjust_queries');
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
