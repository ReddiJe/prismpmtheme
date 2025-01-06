<?php get_header(); ?>

<style>
    
</style>

<div class="content">
    <main class="main">
        <h1>Blog</h1>

        <?php if ( have_posts() ) : ?>

            <!-- Begin the Loop -->
            <?php while ( have_posts() ) : the_post(); ?>

                <div class="post">
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <p class="post-meta">
                        <span class="post-date"><?php echo get_the_date(); ?></span> |
                        <span class="post-author"><?php the_author(); ?></span>
                    </p>

                    <div class="post-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                </div>

            <?php endwhile; ?>

            <div class="pagination">
                <?php
                    the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => __('« Previous'),
                        'next_text' => __('Next »'),
                    ) );
                ?>
            </div>

        <?php else : ?>

            <p><?php _e( 'No posts found.', 'your-theme-textdomain' ); ?></p>

        <?php endif; ?>
    </main>
</div>

<?php get_footer(); ?>
