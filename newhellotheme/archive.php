<?php get_header(); ?>

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

    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <div class="archive-post">
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="excerpt"><?php the_excerpt(); ?></div>
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
