<?php get_header(); ?>

<style>
    .single-post-container .single-post {
        padding: 50px 10%;
    }

    .single-post-container .single-post .subtitle {
        font-size: 2.25rem;
        color: #666;
        margin-bottom: 30px;
    }

    .single-post-container .single-post .post-thumbnail {
        position: relative;
        margin-bottom: 40px;
        margin-top: 40px;
        overflow: hidden;
    }

    .single-post-container .single-post .post-thumbnail img {
        width: 100%;
        height: 550px;
        display: block;
        object-fit: cover;
    }

    .single-post-container .single-post .post-thumbnail::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0));
        z-index: 1;
    }

    .single-post-container .single-post .post-meta {
        position: absolute;
        bottom: 25px;
        color: #fff;
        font-size: 16px;
        padding: 15px 40px;
        display: flex;
        gap: 50px;
        z-index: 2;
        width: 100%;
        justify-content: space-between;
    }

    .single-post-container .single-post .post-meta .post-meta-item {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .single-post-container .single-post .post-content {
        font-size: 16px;
        color: #333;
        padding-left: 20px;
        padding-right: 20px;
    }

    .single-post-container .single-post p {
        margin-bottom: 20px;
    }

    .single-post-container .single-post .post-categories a {
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

.single-post-container .single-post .post-categories a:hover {
    background-color: #F3F4F6;
    text-decoration: none;
    transition-duration: 0.1s;
}

.single-post-container .single-post .post-categories a:disabled {
    background-color: #FAFBFC;
    border-color: rgba(27, 31, 35, 0.15);
    color: #959DA5;
    cursor: default;
}

.single-post-container .single-post .post-categories a:active {
    background-color: #EDEFF2;
    box-shadow: rgba(225, 228, 232, 0.2) 0 1px 0 inset;
    transition: none 0s;
}

.single-post-container .single-post .post-categories a:focus {
    outline: 1px transparent;
}


    .all-posts-button-container {
        text-align: center;
        display: flex;
        justify-content: center;
        margin-top: 50px;
    }

    .all-posts-button-container .all-posts-button {
        text-decoration: none;
        padding: 10px 20px;
        color: #fff;
        background-color: #093D5F;
        display: inline-block;
        font-family: "Graphik Medium", Sans-serif;
        font-size: 12px;
        font-weight: normal;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        font-size: 16px;
    }

    .all-posts-button-container .all-posts-button:hover {
        background-color: #fff;
        color: #093D5F;
        border-color: #093D5F;
    }
</style>

<div class="single-post-container">
    <div class="single-post">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <h1><?php the_title(); ?></h1>

                <div class="post-categories">
                    <?php
                    $categories = get_the_category();
                    if ($categories) :
                        foreach ($categories as $category) :
                            echo '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>';
                        endforeach;
                    endif;
                    ?>
                </div>


                <?php
                // Display subtitle if it exists
                $subtitle = get_post_meta(get_the_ID(), 'subtitle', true);
                if ($subtitle) : ?>
                    <div class="subtitle"><?php echo esc_html($subtitle); ?></div>
                <?php endif; ?>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <div class="post-meta">
                            <div class="post-meta-item">
                                <span>Published on: </span>
                                <span><?php the_date(); ?></span>
                            </div>
                            <div class="post-meta-item">
                                <span>Written by:</span>
                                <span><?php the_author(); ?></span>
                            </div>
                        </div>
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="post-content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile;
        else : ?>
            <p style="text-align: center; font-size: 18px; color: #999;">Post is not found</p>
        <?php endif; ?>
        <div class="all-posts-button-container">
            <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="all-posts-button">All News</a>
        </div>
    </div>
</div>

<?php get_footer(); ?>