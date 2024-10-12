<aside id="secondary" class="widget-area">
    <div class="card mb-4 widget-area__card">
        <div class="card-header card__card-header">
            Search
        </div><!-- .card-header -->
        <div class="card-body card__card-body">
            <div class="card__input-group input-group">
                <input class="card__form-control form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search">
                <button class="card__btn btn btn-primary" id="button-search" type="button">Go!</button>
            </div><!-- .input-group -->
        </div><!-- .card-body -->
    </div><!-- .card mb-4 -->
    <div class="card mb-4 widget-area__card">
        <div class="card-header card__card-header">
            Categories
        </div><!-- .card-header -->
        <div class="card-body card__card-body">
            <div class="card__row row">
                <?php
                    $genres = get_terms(array(
                        'taxonomy' => 'genres',
                        'hide_empty' => true,
                    ));
                    if (!empty($genres) && !is_wp_error($genres)) {
                        echo '<div class="card__col book-genres col-sm-6">';
                        echo '<ul class="card__list">';
                        foreach ($genres as $genre) {
                            echo '<li class="card__item list-unstyled mb-0"><a class="card__link" href="#">' . esc_html($genre->name) . '</a></li>';
                        }
                        echo '</ul>';
                        echo '</div><!-- .book-genres -->';
                        $authors = get_terms(array(
                            'taxonomy' => 'authors',
                            'hide_empty' => true,
                        ));
                    }
                    if (!empty($authors) && !is_wp_error($authors)) {
                        echo '<div class="card__col book-authors col-sm-6">';
                        echo '<ul class="card__list">';
                        foreach ($authors as $author) {
                            echo '<li class="card__item list-unstyled mb-0"><a class="card__link" href="#">' . esc_html($author->name) . '</a></li>';
                        }
                        echo '</ul>';
                        echo '</div><!-- .book-authors -->';
                    }
                ?>
            </div><!-- .row -->
        </div><!-- .card-body -->
    </div><!-- .card mb-4 -->
    <div class="card mb-4 widget-area__card">
        <div class="card-header card__card-header">
            Side Widget
        </div><!-- .card-header -->
        <div class="card-body card__card-body">
            <?php echo do_shortcode('[books genres="Детектив"]'); ?>
        </div><!-- .card-body -->
    </div><!-- .card mb-4 -->
</aside><!-- #secondary -->