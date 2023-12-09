<?php
/**
 * Template Name: Home
 *
 *
 */
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$container = get_theme_mod( 'understrap_container_type' );

/* Creation tableau Json tous les POST */
/* include(get_stylesheet_directory_uri() . '/php/all_post_json.php'); */
?>

<!--Fin Rajout des css OWL-->

<script>const themeDirectoryUri = "<?php echo get_stylesheet_directory_uri(); ?>";</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />



<body>





            


                <?php
                // Do the left sidebar check and open div#primary.
                get_template_part( 'global-templates/left-sidebar-check' );
                ?>
                <header id="banner">

                    <div class="infos">
                        <div class="title"></div>
                        <div class="categories"></div>
                    </div>

                    <div class="arrow arrow_left">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/icon/arrow_left.png" alt="fleche slide gauche">
                    </div>
                    <div class="arrow arrow_right">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/icon/arrow_right.png" alt="fleche slide droite">
                    </div>
                    
                    <div class="dots"></div>

                </header>

            <?php
            // Do the right sidebar check and close div#primary.
			//get_template_part( 'global-templates/right-sidebar-check' );
			?>




</body>
<script src="<?php //echo get_stylesheet_directory_uri() . '/js/jquery-3.7.1.js' ?>"></script>

<script src="<?php echo get_stylesheet_directory_uri() . '/js/slideshow.js' ?>"></script>

<script src="<?php //echo get_stylesheet_directory_uri() . '/js/filters.js' ?>"></script>

<?php //get_sidebar();?>
<?php get_footer();?>