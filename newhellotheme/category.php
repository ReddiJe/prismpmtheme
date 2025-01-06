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

    .post-categories a.active-category {
        color: #fff;
        background-color: #0073aa;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
    }

    .post-categories a.active-category:hover {
        background-color: #005f8d;
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
        padding-top: 25px;
    }

    .custom-posts .post-categories p {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .centered-search {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .search-box {
        position: relative;
        width: 300px;
    }

    .search-box__input {
        width: 100%;
        padding: 12px 40px 12px 16px;
        font-size: 16px;
        border: 2px solid #0073aa;
        border-radius: 50px;
        outline: none;
        transition: 0.3s;
    }

    .search-box__input:focus {
        border-color: #005f8d;
        box-shadow: 0 0 8px rgba(0, 115, 170, 0.3);
    }

    .search-box__icon {
        position: absolute;
        top: 50%;
        right: 16px;
        transform: translateY(-50%);
        font-size: 18px;
        color: #0073aa;
        pointer-events: none;
    }

    .search-box__icon:hover {
        color: #005f8d;
    }

    .hidden {
        display: none;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.querySelector(".search-box__input");
        const searchIcon = document.querySelector(".search-box__icon");

        if (searchInput && searchIcon) {
            searchInput.addEventListener("input", function() {
                if (this.value.trim() !== "") {
                    searchIcon.classList.add("hidden");
                } else {
                    searchIcon.classList.remove("hidden");
                }
            });
        }
    });
</script>

<div class="content">
    <main class="main custom-posts">

        <div class="centered-search">
            <div class="search-box">
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                    <input type="search" class="search-box__input" name="s" placeholder="Search..." required>
                    <i class="search-box__icon fas fa-search"></i>
                </form>
            </div>
        </div>

        <div class="post-categories">
            <h3>Categories:</h3>
            <?php
            $categories = get_categories();
            if ($categories) :
                echo '<p>';
                foreach ($categories as $category) :
                    // Check if this category is the current one
                    $class = (is_category($category->term_id)) ? 'active-category' : '';
                    echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="button-4 ' . $class . '">' . esc_html($category->name) . '</a> ';
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
