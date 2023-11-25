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


?>

<!--Rajout des css OWL-->
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . "/css/owl.carousel.css" ?>">

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . "/css/owl.theme.default.css" ?>">

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . "/css/owl.supercharge.css" ?>">

<!--Fin Rajout des css OWL-->

<script>const themeDirectoryUri = "<?php echo get_stylesheet_directory_uri(); ?>";</script>

<body>

    <div class="wrapper" id="page-wrapper">

        <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

            <div class="row">


                <?php
                // Do the left sidebar check and open div#primary.
                get_template_part( 'global-templates/left-sidebar-check' );
                ?>

                <main class="site-main" id="main">

                    <div class="owl-carousel owl-theme"></div>


                </main>

			<?php
			// Do the right sidebar check and close div#primary.
			get_template_part( 'global-templates/right-sidebar-check' );
			?>


            </div><!-- .row -->

        </div><!-- #content -->

    </div><!-- #page-wrapper -->
</body>
<script src="<?php echo get_stylesheet_directory_uri() . '/js/jquery-3.7.1.js' ?>"></script>

<script src="<?php echo get_stylesheet_directory_uri() . '/js/slideshow.js' ?>"></script>

<script src="<?php //echo get_stylesheet_directory_uri() . '/js/owl.carousel.min.js' ?>"></script>

<script src="<?php //echo get_stylesheet_directory_uri() . '/js/initOwl.js' ?>"></script>
<?php get_sidebar();?>
<?php get_footer();?>