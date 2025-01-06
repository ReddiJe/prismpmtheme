<?php get_header(); ?>

<style>
    .single-post-container .single-post {
        padding: 50px 10%;
    }

    .single-post-container .single-post h1 {
        margin-bottom: 20px;
    }

    .single-post-container .single-post .post-thumbnail {
        position: relative;
        margin-bottom: 40px;
        overflow: hidden;
    }

    .single-post-container .single-post .post-thumbnail img {
        width: 100%;
        height: 500px;
        display: block;
    }

    .single-post-container .single-post .post-thumbnail::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50%;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0)); 
        z-index: 1;
    }

    .single-post-container .single-post .post-meta {
        position: absolute;
        bottom: 15px;
        left: 15px;
        color: #fff;
        font-size: 16px;
        padding: 10px 15px;
        border-radius: 5px;
        display: flex;
        gap: 20px;
        z-index: 2;
    }

    .single-post-container .single-post .post-content {
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

                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <div class="post-meta">
                            <span>Posted: <?php the_date(); ?></span>
                            <span>Author: <?php the_author(); ?></span>
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
    </div>
</div>

<?php get_footer(); ?>
