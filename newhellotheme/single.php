<?php get_header(); ?>

<style>
    .single-post {
        padding: 20px;
    }

    .single-post h1 {
        margin-bottom: 20px;
    }

    .single-post .post-meta {
        margin-bottom: 20px;
        color: #777;
        font-size: 14px;
    }

    .single-post .post-thumbnail img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .single-post .post-content {
        line-height: 1.8;
        font-size: 16px;
        color: #333;
    }

    .single-post p {
        margin-bottom: 20px;
    }
</style>

<div class="single-post" style="padding: 20px; max-width: 800px; margin: 0 auto;">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <h1 style="margin-bottom: 20px;"><?php the_title(); ?></h1>

            <div class="post-meta" style="margin-bottom: 20px; color: #777; font-size: 14px;">
                <span>Posted: <?php the_date(); ?></span> |
                <span>Author: <?php the_author(); ?></span>
            </div>

            <?php if (has_post_thumbnail()) : ?>
                <div class="post-thumbnail" style="margin-bottom: 20px;">
                    <?php the_post_thumbnail('large', ['style' => 'width: 100%; height: auto; border-radius: 8px;']); ?>
                </div>
            <?php endif; ?>

            <div class="post-content" style="line-height: 1.8; font-size: 16px; color: #333;">
                <?php the_content(); ?>
            </div>
        <?php endwhile;
    else : ?>
        <p style="text-align: center; font-size: 18px; color: #999;">Post is not found</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>