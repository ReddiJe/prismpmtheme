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
        background: linear-gradient(to top, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0));
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
</style>

<div class="single-post-container">
    <div class="single-post">
        <?php
        if (have_posts()) :
            while (have_posts()) : the_post(); ?>
                <h1><?php the_title(); ?></h1>

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
    </div>
</div>

<?php get_footer(); ?>