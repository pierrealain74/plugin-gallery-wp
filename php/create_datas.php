<?php
// Récupérez les portfolios depuis l'API 
$portfolio_url = get_site_url() . '/wp-json/wp/v2/posts?_fields=id,title,excerpt,date,categories,tags,featured_media,&per_page=20';


$portfolio_response = wp_remote_get($portfolio_url);
$portfolio_data = wp_remote_retrieve_body($portfolio_response);
$portfolios = json_decode($portfolio_data);

// Tableau pour stocker les données JSON
$portfolio_json = array();
$num = 0;
// Boucle qui recupere des données de chaque portfolio
foreach ($portfolios as $portfolio) :

    $portfolio_item = array(
        'num' => $num,
        'id' => $portfolio->id,
        'title' => esc_html($portfolio->title->rendered),
        'date' => isset($portfolio->date) ? explode("T",  $portfolio->date)[0] : '',
        'categories' => array(),
        'tags' => array(),
        'thumbnail' => '',
        'thumbnailfull' => '',
        /* 'content' => esc_html($portfolio->content->rendered),  pas besoin car j'utilise une autre url*/

    );
    $num++;

    // Récupérer l'image à la une (thumbnail)
    $thumbnail_id = $portfolio->featured_media;
    $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'thumbnail');
    $portfolio_item['thumbnail'] = esc_url($thumbnail_url);

    // Récupérer l'image FULL à la une (thumbnail)
    $thumbnail_id = $portfolio->featured_media;
    $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'full');
    $portfolio_item['thumbnailfull'] = esc_url($thumbnail_url);

    // Récupérer les catégories
    if (isset($portfolio->categories) && is_array($portfolio->categories)) {
        foreach ($portfolio->categories as $category_id) {
            $category = get_term($category_id, 'category');
            if ($category && !is_wp_error($category)) {
                $portfolio_item['categories'][] = esc_html($category->name);
            }
        }
    }

    // Récupérer les balises (tags)
    if (isset($portfolio->tags) && is_array($portfolio->tags)) {
        foreach ($portfolio->tags as $tag_id) {
            $tag = get_term($tag_id, 'post_tag');
            if ($tag && !is_wp_error($tag)) {
                $portfolio_item['tags'][] = esc_html($tag->name);
            }
        }
    }

    // Ajouter l'élément au tableau JSON
    $portfolio_json[] = $portfolio_item;
    ?>



<?php
endforeach;


// Convertir le tableau JSON en une chaîne JSON
$portfolio_json = json_encode($portfolio_json, JSON_PRETTY_PRINT);

//Afficher le Json préformaté
echo '<pre>' . htmlspecialchars($portfolio_json, ENT_QUOTES, 'UTF-8') . '</pre>';

//print_r($portfolio_json);
?>

