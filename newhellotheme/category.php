<?php get_header(); ?>

<style>
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

    .post-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: flex-start;
        margin-top: 20px;
    }

    .custom-posts .post {
        display: flex;
        flex-direction: column;
        width: calc(33.333% - 20px);
        margin-bottom: 20px;
        border-radius: 10px;
        transition: transform 0.5s ease, box-shadow 0.5s ease;
    }

    .custom-posts .post:hover {
        transform: translateY(-3px);
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }

    .custom-posts .post-thumbnail {
        width: 100%;
        height: auto;
    }

    .custom-posts .post-thumbnail img {
        width: 100%;
        height: 225px;
        border-radius: 10px;
    }

    .custom-posts .post-content {
        display: flex;
        flex-direction: column;
        padding: 0 15px 15px 15px;
        height: 100%;
        justify-content: space-between;
    }

    .custom-posts .post-title {
        font-size: 24px;
        margin-bottom: 10px;
        color: #333;
        text-decoration: none;
    }

    .custom-posts .post-meta {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: #777;
    }

    .custom-posts .post-meta .post-date,
    .custom-posts .post-meta .post-author {
        color: #555;
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

    .post-categories,
    .post-tags {
        font-size: 16px;
        color: #555;
    }

    .post-categories a,
    .post-tags a {
        color: #2c2d2c;
        text-decoration: none;
        position: relative;
    }

    .custom-posts .post-categories {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding-top: 25px;
    }

    .custom-posts .post-categories p {
        display: flex;
        gap: 25px;
        flex-wrap: wrap;
    }

    .custom-posts .post-categories a {
        color: #093D5F;
        text-decoration: none;
        position: relative;
    }

    .custom-posts .post-categories a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        right: 0;
        width: 0;
        height: 2px;
        background-color: #093D5F;
        transition: width 0.3s ease, left 0.3s ease;
    }

    .custom-posts .post-categories a:hover::after {
        width: 100%;
        left: 0;
    }

    .custom-posts .post-categories a.active-category::after {
        width: 100%;
        left: 0;
        background-color: #093D5F;
    }

    .custom-posts .post-categories a.active-category {
        color: #093D5F;
    }

    .custom-posts .post-author {
        display: none;
    }

    @media (max-width: 1024px) {
        .custom-posts .post {
            width: calc(50% - 20px);
        }
    }

    @media (max-width: 768px) {
        .custom-posts .post {
            width: 100%;
        }
    }
</style>

<div class="content">
    <main class="main custom-posts">

        <div class="post-categories">
            <h3>Categories:</h3>
            <?php
            $categories = get_categories();
            if ($categories) :
                echo '<p>';
                foreach ($categories as $category) :
                    $class = (is_category($category->term_id)) ? 'active-category' : '';
                    echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="' . $class . '">' . esc_html($category->name) . '</a> ';
                endforeach;
                echo '</p>';
            endif;
            ?>
        </div>

        <div class="post-grid">
            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                    <div class="post">
                        <a href="<?php the_permalink(); ?>">
                            <div class="post-thumbnail">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="post-content">
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>

                                <div class="post-meta">
                                    <span class="post-date"><?php echo get_the_date(); ?></span>
                                    <span class="post-author" style="display: none;"><?php the_author(); ?></span>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php endwhile; ?>

            <?php else : ?>

                <p><?php _e('No posts found.', 'your-theme-textdomain'); ?></p>

            <?php endif; ?>
        </div>

        <div class="pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size'  => 2,
                        'prev_text' => __('« Previous'),
                        'next_text' => __('Next »'),
                    ));
                    ?>
                </div>

    </main>
</div>

<?php get_footer(); ?>