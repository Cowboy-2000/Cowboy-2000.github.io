<?php
    get_header();
?>
<main id="primary" class="site-main">
    <div class="container site-main__container">
        <div class="row site-main__row">
            <div class="col-lg-8 site-main__col">
                <?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                    'post_type' => 'kniga',
                    'posts_per_page' => -1,
                    'paged' => $paged,
                    'orderby' => 'title',
                    'order' => 'ASC',
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                            $query->the_post();
                            echo '<div class="card mb-4">';
                            echo '<a href="#"><img class="card-img-top" src="https://dummyimage.com/700x350/dee2e6/6c757d.jpg" alt="..."></a>'; // Ссылка на страницу книги
                            echo '</div>';
                            echo '<div class="card-body"><div class="small text-muted">' . get_the_date('F d, Y') . '</div>';
                            echo '<h2 class="card-title h4">' . get_the_title() . '</h2>';
                            echo '<p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis!</p>';
                            echo '<a class="btn btn-primary" href="' . get_the_permalink() . '">Read more →</a>';
                        }
                    } else {
                        echo '<p>Книги не найдены.</p>';
                    }
                ?>
            </div><!-- .site-main__col -->
            <div class="col-lg-4 site-main__col">
                <?php get_sidebar(); ?>
            </div><!-- .site-main__col -->
        </div><!-- .site-main__row -->
    </div><!-- .site-main__container -->
</main><!-- #main -->
<?php
    get_footer();
?>