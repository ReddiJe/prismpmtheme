<?php get_header(); ?>

<style>
    /* Стили для добавленных элементов поиска и категорий */
    .custom-posts {
        padding-left: 10%;
        padding-right: 10%;
    }
    .search-form {
        text-align: center;
        margin-bottom: 20px;
    }
    .search-form input[type="search"] {
        padding: 8px;
        width: 60%;
        font-size: 16px;
    }
    .custom-posts .post {
        display: flex;
        margin-bottom: 20px;
        margin-top: 20px;
    }

    .custom-posts .post-thumbnail {
        width: 200px;
        margin-right: 20px;
        overflow: hidden;
    }

    .custom-posts .post-thumbnail img {
        width: 100%;
        height: auto;
    }

    .custom-posts .post-content {
        flex-grow: 1;
    }

    .custom-posts .post-title {
        font-size: 24px;
        margin-bottom: 10px;
        color: #333;
    }

    .custom-posts .post-meta {
        font-size: 14px;
        color: #777;
    }

    .custom-posts .post-meta .post-date,
    .custom-posts .post-meta .post-author {
        color: #555;
    }

    .custom-posts .post-excerpt {
        font-size: 16px;
        margin-top: 10px;
        color: #333;
    }

    .custom-posts .pagination {
        text-align: center;
        margin-top: 20px;
    }

    .custom-posts .pagination .page-numbers {
        display: inline-block;
        margin: 0 5px;
        padding: 8px 16px;
        background-color: #f0f0f0;
        color: #333;
        text-decoration: none;
        border-radius: 4px;
    }

    .custom-posts .pagination .page-numbers.current {
        background-color: #0073aa;
        color: #fff;
    }

    .custom-posts .pagination .page-numbers:hover {
        background-color: #005f8d;
        color: #fff;
    }

    .custom-posts .post-title a {
        color: #333;
        text-decoration: none;
    }

    .custom-posts .post-title a:hover {
        color: #0073aa;
        text-decoration: underline;
    }

    /* Стиль для категории и тегов */
    .post-categories, .post-tags {
        font-size: 14px;
        color: #555;
    }

    .post-categories a, .post-tags a {
        color: #0073aa;
        text-decoration: none;
    }

    .post-categories a:hover, .post-tags a:hover {
        text-decoration: underline;
    }
</style>

<div class="content">
    <main class="main custom-posts">

        <!-- Форма поиска -->
        <div class="search-form">
            <?php get_search_form(); ?>
        </div>

        <!-- Вывод категорий -->
        <div class="post-categories">
            <h3>Категории:</h3>
            <?php
            $categories = get_categories();
            if ($categories) :
                echo '<ul>';
                foreach ($categories as $category) :
                    echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a></li>';
                endforeach;
                echo '</ul>';
            endif;
            ?>
        </div>

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <div class="post">
                    <div class="post-thumbnail">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="post-content">
                        <p class="post-meta">
                            <span class="post-date"><?php echo get_the_date(); ?></span> |
                            <span class="post-author"><?php the_author(); ?></span>
                        </p>

                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <div class="post-excerpt">
                            <?php
                            $content = get_the_content();
                            $concept = wp_trim_words($content, 30, '...');
                            echo $concept;
                            ?>
                        </div>

                        <!-- Вывод тегов для каждого поста -->
                        <div class="post-tags">
                            <?php
                            $tags = get_the_tags();
                            if ($tags) :
                                echo '<h3>Теги:</h3><ul>';
                                foreach ($tags as $tag) :
                                    echo '<li><a href="' . esc_url(get_tag_link($tag->term_id)) . '">' . esc_html($tag->name) . '</a></li>';
                                endforeach;
                                echo '</ul>';
                            endif;
                            ?>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>

            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('« Previous'),
                    'next_text' => __('Next »'),
                ));
                ?>
            </div>

        <?php else : ?>

            <p><?php _e('No posts found.', 'your-theme-textdomain'); ?></p>

        <?php endif; ?>
    </main>
</div>

<?php get_footer(); ?>
