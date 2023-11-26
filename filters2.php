<?php 

/**
 * Template Name: Filters2
 * 
 * Ce template de page permet d'afficher tous les POSTS d'une categorie donnée via
 * 
 * un select de catégories
 * 
 * Le but est d'utiliser uniquement l'API Rest (aucune requete wp_query) avec AJAX et Fetch
 *
 */

 // Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();


$container = get_theme_mod('understrap_container_type');

?>

<body>

    <div class="wrapper" id="page-wrapper">

        <div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

            <div class="row">


                <?php
                // Do the left sidebar check and open div#primary.
                get_template_part( 'global-templates/left-sidebar-check' );
                ?>

                <main class="site-main" id="main">

                <div class="bloggerfilter">

                    
                    <div class="filters">

                        <select name="cat" id="cat-select" class="form-select form-select-lg mb-3" aria-label="Large select example">
                            <option value="" selected>--Choisissez une catégorie--</option>
                            <option value="3">News</option>
                            <option value="4">Sport</option>
                        </select>

                    </div>
                    <div id="blogger"></div>

                </div>


                <script>

                document.addEventListener("DOMContentLoaded", function () {

                    const categorySelect = document.getElementById("cat-select");
                    
                    const bloggerElt = document.getElementById("blogger");

                    categorySelect.addEventListener("change", function() {
                        bloggerElt.textContent = '';

                        const categoryId = categorySelect.value;

                        // Effectuer la requête AJAX vers la fonction personnalisée
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', '/wp-admin/admin-ajax.php?action=get_thumbnails_by_category&category_id=' + categoryId);

                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // La réponse est au format JSON
                                var thumbnails = JSON.parse(xhr.responseText);

                                thumbnails.forEach((thumbnail_url) => {
                                    const divElt = document.createElement('div');
                                    divElt.classList.add('divImg');

                                    const imgElt = document.createElement('img');
                                    imgElt.src = thumbnail_url;

                                    divElt.appendChild(imgElt);
                                    bloggerElt.appendChild(divElt);
                                });
                            } else {
                                console.error('Erreur lors de la requête AJAX');
                            }
                        }

                        xhr.send();
                    });
                });






                </script>




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

<script src="<?php echo get_stylesheet_directory_uri() . '/js/filters.js' ?>"></script>


<?php get_sidebar();?>
<?php get_footer();?>                