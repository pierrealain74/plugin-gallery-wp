<?php 

/**
 * Template Name: Filters
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

                        
                            //Recupere le DOM des 3 SELECT
                            const categorySelect = document.getElementById("cat-select");
                            const bloggerElt = document.getElementById("blogger");
                            

                            categorySelect.addEventListener("change", function() {

                                bloggerElt.textContent = '';
                                
                                const categoryId = categorySelect.value;

                                //Créer la requete AJAX !!
                                var xhr = new XMLHttpRequest();
                                xhr.open('GET', '/wp-json/wp/v2/posts?categories=' + categoryId);

                                //xhr.onload = async function() {
                                xhr.onload = function() {


                                    if (xhr.status === 200) {

                                        // La réponse est au format JSON
                                        var posts = JSON.parse(xhr.responseText);

                                        //for (const item of posts) {
                                        posts.forEach( async(post) => {
                                            
                                           
                                            // Accédez à l'URL de la thumbnail
                                            // genre : http://wordpress-defaut.local/wp-json/wp/v2/media/71
                                            var thumbnailUrl = post._links['wp:featuredmedia'][0].href;

                                            //Ne prend que l'id à la fin de l'url : 71
                                            const featuredMediaId = thumbnailUrl.split('/').pop();

                                            //Fonction qui appelle l'api media wp-json/wp/v2/media/71
                                            //pour convertir l'id media en URL
                                            let featuredMediaUrl = await fetchMedia(featuredMediaId);

                                            const divElt = document.createElement('div');
                                            divElt.classList.add('divImg');

                                            const imgElt = document.createElement('img');
                                            imgElt.src = featuredMediaUrl;

                                            divElt.appendChild(imgElt);
                                            bloggerElt.appendChild(divElt);




                                    })


                                    //console.log('les posts de la categorie ', categoryId, ' : ', posts);

                                    } else {
                                    console.error('Erreur lors de la requête AJAX');
                                    }
                                    
                                }
                                xhr.send();
                                
                            });

                        });


                        function fetchMedia(thumbnailId){

                            const urLocation = window.location.origin;

                            return fetch(`${urLocation}/wp-json/wp/v2/media/${thumbnailId}`)

                            .then(response => response.json())

                            .then(thumbnail => thumbnail.source_url)

                            .catch(error => console.error('Error fetching media data:', error));

                            return null;

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
<script src="<?php echo get_stylesheet_directory_uri() . '/js/jquery-3.7.1.js' ?>"></script>

<script src="<?php echo get_stylesheet_directory_uri() . '/js/filters.js' ?>"></script>


<?php get_sidebar();?>
<?php get_footer();?>