<?php get_header(); ?>

<style>
    /* Custom styles */
    .archive-post {
        display: flex;
        margin-bottom: 20px;
    }

    .archive-post img {
        width: 200px; /* Set width for the image */
        height: auto;
        margin-right: 20px;
    }

    .archive-post .post-content {
        max-width: calc(100% - 220px); /* Ensure text takes the remaining space */
    }

    .post-meta {
        margin: 10px 0;
        font-size: 14px;
        color: #666;
    }

    .concept {
        font-size: 14px;
        color: #333;
    }
</style>

<div class="archive">
    <h1>
        <?php
        if (is_category()) {
            single_cat_title();
        } elseif (is_tag()) {
            single_tag_title();
        } elseif (is_date()) {
            echo 'Archive for ' . get_the_date('F Y');
        } else {
            echo 'Archive';
        }
        ?>
    </h1>
    
    <h1>Hello</h1>

    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <div class="archive-post">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium'); ?> <!-- Display image -->
                        </a>
                    </div>
                <?php endif; ?>

                <div class="post-content">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <p class="post-meta">
                        <span class="post-date"><?php echo get_the_date(); ?></span>
                        <span class="post-author"><?php the_author(); ?></span>
                    </p>
                    <p class="concept"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p> <!-- Limit to 100 characters -->
                </div>
            </div>
        <?php endwhile;

        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => __('« Back'),
            'next_text' => __('Next »'),
        ));
    else : ?>
        <p>Empty.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
