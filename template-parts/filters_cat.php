<?php

function get_all_categories() {
    $categories = get_categories();
    $category_list = array();

    foreach ($categories as $category) {
        $category_list[$category->cat_ID] = $category->name;
    }

    return $category_list;
}
$all_categories = get_all_categories();
?>
<select name="cat" id="cat-select" class="form-select form-select-lg mb-3 w-25" aria-label="Large select example">
        <option value="">Toutes les catégories</option>
        <?php
        foreach ($all_categories as $cat_id => $cat_name) {
            echo '<option value="' . esc_attr($cat_id) . '">' . esc_html($cat_name) . '</option>';
        }
        ?>
</select>
