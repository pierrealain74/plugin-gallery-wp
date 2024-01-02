<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


/**
 * 
 * Création dun Carousel
 * Créer un tableau JSON de tous les POST
 * 
 */


function create_json_all_post(){

    if(is_front_page()){
        require_once get_stylesheet_directory() . '/php/all_posts_json.php';
//        exit;
    }
}

add_action('wp', 'create_json_all_post');


/**
 * 
 * Supprimer le script automatique de WP sur les emojis
 * 
 * @return void
 */
function disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
add_action('init', 'disable_emojis');

function disable_emojis_tinymce($plugins) {
    return array_diff($plugins, array('wpemoji'));
}




// Exposer l'URL de l'icone d'une catégorie via l'API REST
function exposer_url_image_categorie_via_rest() {
    register_rest_field('category',
        'image_url',
        array(
            'get_callback' => 'obtenir_url_image_categorie',
            'update_callback' => null,
            'schema' => null,
        )
    );
}

add_action('rest_api_init', 'exposer_url_image_categorie_via_rest');

function obtenir_url_image_categorie($object, $field_name, $request) {

    $image_url = get_term_meta($object['id'], 'image_categorie', true);
    return esc_url($image_url);
}






/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme = wp_get_theme();

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $the_theme->get( 'Version' ) );

	wp_enqueue_script( 'jquery' );

	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $the_theme->get( 'Version' ), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	$theme_paf  = "/css/pafstyles.css";

	wp_enqueue_style( 'pafstyles', get_stylesheet_directory_uri() . $theme_paf, array(), $the_theme->get( 'Version' ) );


    $theme_paf_responsive  = "/css/responsive.css";

	wp_enqueue_style( 'pafstyles_responsive', get_stylesheet_directory_uri() . $theme_paf_responsive, array(), $the_theme->get( 'Version' ) );

}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @return string
 */
function understrap_default_bootstrap_version() {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );


// Fonction pour récupérer les url des thumbnail par catégorie
// pour la page filters2.php en ajax (à verifier)
function get_thumbnails_by_category() {

    $category_id = $_GET['category_id'];
    
    $args = array(
        'cat' => $category_id,
        'post_type' => 'post',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    $thumbnails = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $thumbnail_id = get_post_thumbnail_id();
            $thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'full')[0];

            $thumbnails[] = $thumbnail_url;
        }
    }

    wp_reset_postdata();

    echo json_encode($thumbnails);

    die(); // Stop l'exécution après la sortie JSON
}

add_action('wp_ajax_get_thumbnails_by_category', 'get_thumbnails_by_category');
add_action('wp_ajax_nopriv_get_thumbnails_by_category', 'get_thumbnails_by_category');

/**
 * Get the domaine name + https / http
 */
function get_the_url_domainename(){

	$fullUrl = 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	

}
add_action('wp_enqueue_scripts', 'get_the_url_domainename');
