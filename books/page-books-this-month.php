<?php
/*
Template Name: Books This Month
*/

get_header();
?>

<div class="container">
    <h1><?php _e('Книги, опубліковані в поточному місяці', 'text_domain'); ?></h1>

    <?php
        $current_month = date('m');
        $current_year = date('Y');
        $args = array(
                'post_type' => 'book',
                'posts_per_page' => -1,
                'date_query' => array(
                    array(
                        'year'  => $current_year,
                        'month' => $current_month,
                    ),
                ),
            );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
           echo '<ul class="book-list">';
           while ($query->have_posts()) {
               $query->the_post();
               echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
           }
           echo '</ul>';
        } else {
            echo '<p>' . __('Книги не знайдено за поточний місяць.', 'text_domain') . '</p>';
        }
    wp_reset_postdata();
    ?>


</div>

<?php get_footer();