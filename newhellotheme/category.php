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
        justify-content: space-between;
        margin-top: 20px;
    }

    .custom-posts .post {
        display: flex;
        flex-direction: column;
        width: calc(33.333% - 20px);
        /* 3 posts per row */
        margin-bottom: 20px;
        border-radius: 10px;
        transition: transform 0.5s ease, box-shadow 0.5s ease;
    }

    .custom-posts .post:hover {
        transform: translateY(-3px);
        /* Moves the post 2-3px upwards */
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        /* Adds the box-shadow on hover */
    }

    .custom-posts .post-thumbnail {
        width: 100%;
        height: auto;
    }

    .custom-posts .post-thumbnail img {
        width: 100%;
        height: auto;
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
        gap: 10px;
        flex-wrap: wrap;
    }

    .button-55 {
        align-self: center;
        background-color: #fff;
        background-image: none;
        background-position: 0 90%;
        background-repeat: repeat no-repeat;
        background-size: 4px 3px;
        border-radius: 15px 225px 255px 15px 15px 255px 225px 15px;
        border-style: solid;
        border-width: 2px;
        box-shadow: rgba(0, 0, 0, .2) 15px 28px 25px -18px;
        box-sizing: border-box;
        color: #41403e;
        cursor: pointer;
        display: inline-block;
        font-family: Neucha, sans-serif;
        font-size: 1rem;
        line-height: 23px;
        outline: none;
        padding: .75rem;
        text-decoration: none;
        transition: all 235ms ease-in-out;
        border-bottom-left-radius: 15px 255px;
        border-bottom-right-radius: 225px 15px;
        border-top-left-radius: 255px 15px;
        border-top-right-radius: 15px 225px;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
    }

    .button-55:hover {
        box-shadow: rgba(0, 0, 0, .3) 2px 8px 8px -5px;
        transform: translate3d(0, 2px, 0);
    }

    .button-55:focus {
        box-shadow: rgba(0, 0, 0, .3) 2px 8px 4px -6px;
    }

    .post-categories a.active-category {
        box-shadow: rgba(0, 0, 0, .3) 2px 8px 8px -5px;
        transform: translate3d(0, 2px, 0);
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
                    echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button-55 ' . $class . '">' . esc_html($category->name) . '</a> ';
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
                                    <span class="post-author"><?php the_author(); ?></span>
                                </div>
                            </div>
                        </a>
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
        </div>

    </main>
</div>

<?php get_footer(); ?>