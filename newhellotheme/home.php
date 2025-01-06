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

    .button-4 {
        appearance: none;
        background-color: #FAFBFC;
        border: 1px solid rgba(27, 31, 35, 0.15);
        border-radius: 6px;
        box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
        box-sizing: border-box;
        color: #24292E;
        cursor: pointer;
        display: inline-block;
        font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
        font-size: 14px;
        font-weight: 500;
        line-height: 20px;
        list-style: none;
        padding: 6px 16px;
        position: relative;
        transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        vertical-align: middle;
        white-space: nowrap;
        word-wrap: break-word;
    }

    .button-4:hover {
        background-color: #F3F4F6;
        text-decoration: none;
        transition-duration: 0.1s;
    }

    .button-4:disabled {
        background-color: #FAFBFC;
        border-color: rgba(27, 31, 35, 0.15);
        color: #959DA5;
        cursor: default;
    }

    .button-4:active {
        background-color: #EDEFF2;
        box-shadow: rgba(225, 228, 232, 0.2) 0 1px 0 inset;
        transition: none 0s;
    }

    .button-4:focus {
        outline: 1px transparent;
    }

    .custom-posts .post-categories {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }


    .custom-posts .post-categories p {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-form {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
    }

    .search-form .box {
        position: relative;
    }

    .search-form .input {
        padding: 10px;
        width: 80px;
        height: 80px;
        background: none;
        border: 4px solid #ffd52d;
        border-radius: 50px;
        box-sizing: border-box;
        font-family: Comic Sans MS, sans-serif;
        font-size: 26px;
        color: #ffd52d;
        outline: none;
        transition: 0.5s;
    }

    .search-form .box:hover .input {
        width: 350px;
        background: #3b3640;
        border-radius: 10px;
    }

    .search-form .box i {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translate(-50%, -50%);
        font-size: 26px;
        color: #093D5F;
        transition: 0.2s;
    }

    .search-form .box:hover i {
        opacity: 0;
        z-index: -1;
    }
</style>

<div class="content">
    <main class="main custom-posts">

        <div class="search-form">
            <div class="box">
                <input type="search" name="s" class="input" placeholder="Search..." value="<?php echo get_search_query(); ?>">
                <i class="fas fa-search"></i>
            </div>
        </div>


        <div class="post-categories">
            <h3>Categories:</h3>
            <?php
            $categories = get_categories();
            if ($categories) :
                echo '<p>';
                foreach ($categories as $category) :
                    echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button-4">' . esc_html($category->name) . '</a> ';
                endforeach;
                echo '</p>';
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

                        <div class="post-tags">
                            <?php
                            $tags = get_the_tags();
                            if ($tags) :
                                echo '<h3>Tags:</h3><ul>';
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