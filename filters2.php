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

                <header class="entry-header"><h1 class="entry-title">Filtre par catégories</h1></header>
                <div class="entry-content">
                    <h2>Utilisation de Ajax, Php, functions.php</h2>
                </div>

                <div class="bloggerfilter">

                    
                    <div class="filters">

                    <select name="cat" id="cat-select" class="form-select form-select-lg mb-3" aria-label="Large select example">
                        <option value="" selected>--Choisissez une catégorie--</option>
                        <option value="3">Voitures de sport</option>
                        <option value="4">Voitures de collection</option>
                        <option value="6
                        ">Avions</option>
                    </select>

                    </div>
                    <div id="blogger"></div>

                </div>


                <script>

                document.addEventListener("DOMContentLoaded", function () {

                    const categorySelect = document.getElementById("cat-select"); 
                    const categoryId = '';

                    displayPost(categoryId);


                    categorySelect.addEventListener("change", function() {

                        const categoryId = categorySelect.value;
                        displayPost(categoryId);

                        
                    });
                });


                function displayPost(cat){
                    
                    const bloggerElt = document.getElementById("blogger");
                    bloggerElt.textContent = '';
                    const urLocation = window.location.origin;

                    // Requête AJAX vers la fonction personnalisée
                    var xhr = new XMLHttpRequest();
                    
                    xhr.open('GET', urLocation + '/wp-admin/admin-ajax.php?action=get_thumbnails_by_category&category_id=' + cat);
                    //Declanche la requete ajax côté serveur

                    //Crée un tableau json et le rends dispo coté client
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
                }



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

<?php get_sidebar();?>
<?php get_footer();?>                