<?php
    function books_setup() {
        add_theme_support( 'post-thumbnails' );
        add_theme_support('title-tag');
        register_nav_menus(
            array(
                'menu-1' => esc_html__( 'Primary', 'books' ),
            )
        );
    }
    add_action( 'after_setup_theme', 'books_setup' );
    function books_widgets_init() {
        register_sidebar (
            array(
                'name'          => esc_html__( 'Sidebar', 'books' ),
                'id'            => 'sidebar-1',
                'description'   => esc_html__( 'Add widgets here.', 'books' ),
                'before_widget' => '<section id="%1$s" class="widget %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<h2 class="widget-title">',
                'after_title'   => '</h2>',
            )
        );
    }
add_action( 'widgets_init', 'books_widgets_init' );
    add_action( 'wp_enqueue_scripts', function() {
        wp_enqueue_style( 'books-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css' );
    	wp_enqueue_style( 'books-styles', get_template_directory_uri() . '/style.css' );
    	wp_enqueue_script( 'jquery' );
    	wp_enqueue_script( 'books-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js', array(), false, true );
    	wp_enqueue_script( 'books-script', get_template_directory_uri() . '/assets/js/script.js', array(), false, true );
    } );
    add_filter('the_content', 'my_the_content');
    function my_the_content($content) {
    	return strip_tags($content);
    }

    add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 4 );
    function special_nav_class($classes, $item, $args, $depth) {
        $classes[] = 'nav__item';
        if ($depth > 0) {
            $classes[] = 'nav__item--submenu';
        }
        return $classes;
    }


    add_filter( 'nav_menu_submenu_css_class', 'special_nav_submenu_class', 10, 3 );
    function special_nav_submenu_class($classes, $args, $depth) {
        $classes[] = 'nav__list nav__list--submenu';
        return $classes;
    }

    add_filter( 'nav_menu_link_attributes', 'special_nav_link_attributes', 10, 4 );
    function special_nav_link_attributes($atts, $item, $args, $depth) {
        $atts['class'] = 'nav__link';
        if ($depth > 0) {
            $atts['class'] = 'nav__link nav__link--submenu';
        }
        return $atts;
    }
    function create_book_taxonomies() {
        $labels = array(
                'name'              => 'Жанри',
                'singular_name'     => 'Жанр',
                'search_items'      => 'Пошук жанрів',
                'all_items'         => 'Всі жанри',
                'parent_item'       => 'Батьківський жанр',
                'parent_item_colon' => 'Батьківський жанр:',
                'edit_item'         => 'Редагувати жанр',
                'update_item'       => 'Оновити жанр',
                'add_new_item'      => 'Додати новий жанр',
                'new_item_name'     => 'Назва нового жанру',
                'menu_name'         => 'Жанри',
            );

            register_taxonomy('genre', 'book', array(
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_in_rest'      => true,
                'rewrite'           => array('slug' => 'genre'),
            ));

            // Таксономія "Автори"
            $labels = array(
                'name'              => 'Автори',
                'singular_name'     => 'Автор',
                'search_items'      => 'Пошук авторів',
                'all_items'         => 'Всі автори',
                'edit_item'         => 'Редагувати автора',
                'update_item'       => 'Оновити автора',
                'add_new_item'      => 'Додати нового автора',
                'new_item_name'     => 'Назва нового автора',
                'menu_name'         => 'Автори',
            );

            register_taxonomy('author', 'book', array(
                'hierarchical'      => false,
                'labels'            => $labels,
                'show_in_rest'      => true,
                'rewrite'           => array('slug' => 'author'),
            )
        );
    }
    add_action('init', 'create_book_taxonomies');
    function books_by_genre_shortcode($atts) {
        // Отримуємо атрибути шорткоду
        $atts = shortcode_atts(array(
            'genres' => '', // За замовчуванням жанр не вказаний
        ), $atts, 'books');

        // Якщо жанр не вказаний, повертаємо повідомлення
        if (empty($atts['genres'])) {
            return 'Будь ласка, вкажіть жанр у шорткоді.';
        }

        // Запит для отримання книг певного жанру
        $query_args = array(
            'post_type' => 'book',
            'tax_query' => array(
                array(
                    'taxonomy' => 'genres',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($atts['genres']),
                ),
            ),
        );

        $query = new WP_Query($query_args);

        // Формування HTML-коду для виводу книжок
        $output = '<ul class="book-list">';
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
        } else {
            $output .= '<li>Книг у цьому жанрі не знайдено.</li>';
        }
        $output .= '</ul>';

        // Відновлюємо початковий запит
        wp_reset_postdata();

        return $output;
    }
    add_shortcode('books', 'books_by_genre_shortcode');
    add_filter('widget_text', 'do_shortcode');
    class Latest_Books_By_Author_Widget extends WP_Widget {

        // Конструктор віджета
        public function __construct() {
            parent::__construct(
                'latest_books_by_author_widget', // Ідентифікатор віджета
                __('Останні книги від автора', 'text_domain'), // Назва віджета
                array('description' => __('Показує останні 5 книг від певного автора', 'text_domain'))
            );
        }

        // Відображення форми налаштувань віджета в адмінці
        public function form($instance) {
            $author_id = !empty($instance['author_id']) ? $instance['author_id'] : '';
            ?>
            <p>
                <label for="<?php echo $this->get_field_id('author_id'); ?>"><?php _e('ID автора:'); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id('author_id'); ?>" name="<?php echo $this->get_field_name('author_id'); ?>" type="text" value="<?php echo esc_attr($author_id); ?>" />
            </p>
            <?php
        }

        // Вивід віджета на фронті
        public function widget($args, $instance) {
            $author_id = !empty($instance['author_id']) ? $instance['author_id'] : '';

            if (!empty($author_id)) {
                // Запит для отримання останніх 5 книг від автора
                $query_args = array(
                    'post_type' => 'book',
                    'posts_per_page' => 5,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'authors',
                            'field' => 'term_id',
                            'terms' => $author_id,
                        ),
                    ),
                );

                $query = new WP_Query($query_args);

                if ($query->have_posts()) {
                    echo $args['before_widget'];
                    echo $args['before_title'] . __('Останні книги від автора', 'text_domain') . $args['after_title'];
                    echo '<ul class="latest-books-list">';
                    while ($query->have_posts()) {
                        $query->the_post();
                        echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
                    }
                    echo '</ul>';
                    echo $args['after_widget'];
                    wp_reset_postdata();
                } else {
                    echo $args['before_widget'];
                    echo $args['before_title'] . __('Останні книги від автора', 'text_domain') . $args['after_title'];
                    echo '<p>Книг не знайдено.</p>';
                    echo $args['after_widget'];
                }
            }
        }
    }

    // Реєстрація віджета
    function register_latest_books_by_author_widget() {
        register_widget('Latest_Books_By_Author_Widget');
    }
    add_action('widgets_init', 'register_latest_books_by_author_widget');
?>