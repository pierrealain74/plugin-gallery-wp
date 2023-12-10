<?php
// Récupérer tous les POST
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => -1, // Récupérer tous les articles
);

$query = new WP_Query($args);

// Tableau pour stocker toutes les données
$data = array();

// Vérifier si des articles ont été trouvés
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();

        // Récupérer les catégories
        $categories = get_the_category();
        $category_names = array();
        foreach ($categories as $category) {
            $category_names[] = $category->name;
        }

        // Récupérer la miniature
        $thumbnail = get_the_post_thumbnail_url();

        // Ajouter les informations à notre tableau de données
        $data[] = array(
            'title' => get_the_title(),
            'category' => $category_names,
            'thumbnail' => $thumbnail,
        );
    }

    // Réinitialiser la requête
    wp_reset_postdata();
}

// Convertir le tableau en format JSON
//$all_posts_json = json_encode($data, JSON_PRETTY_PRINT);
// Afficher le résultat
/* echo 'ici le json : ' . $all_posts_json; */

/* print_r($data); */
?>

<script>const all_posts_json = <?php echo json_encode($data, JSON_PRETTY_PRINT);?></script>

