<?php get_header(); ?>

<style>
    .single-post-container .single-post {
        padding: 50px 10%;
    }

    .single-post-container .single-post h1 {
        margin-bottom: 20px;
    }

    .single-post-container .single-post .post-meta {
        margin-bottom: 20px;
        color: #777;
        font-size: 14px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .single-post-container .single-post .post-thumbnail img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .single-post-container .single-post .post-content {
        line-height: 1.8;
        font-size: 16px;
        color: #333;
    }

    .single-post-container .single-post p {
        margin-bottom: 20px;
    }
</style>

<div class="single-post-container">
    <div class="single-post">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <h1><?php the_title(); ?></h1>

                <div class="post-meta">
                    <span>Posted: <?php the_date(); ?></span>
                    <span>Author: <?php the_author(); ?></span>
                </div>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
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
    </div>
</div>

<?php get_footer(); ?>
