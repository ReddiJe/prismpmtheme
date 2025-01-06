<?php get_header(); ?>

<div class="single-post">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <div class="post-meta">
                <span>Posted: <?php the_date(); ?></span>
                <span>Autor: <?php the_author(); ?></span>
            </div>
            <div class="post-content">
                <?php the_content(); ?>
            </div>
        <?php endwhile;
    else : ?>
        <p>Post is not found</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>
