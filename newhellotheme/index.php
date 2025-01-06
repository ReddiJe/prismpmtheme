<?php get_header(); ?>

<style>
    /* Стили для макета новости */
    .post {
        display: flex;
        margin-bottom: 20px;
    }

    .post-thumbnail {
        width: 200px;
        margin-right: 20px;
        overflow: hidden;
    }

    .post-thumbnail img {
        width: 100%;
        height: auto;
    }

    .post-content {
        flex-grow: 1;
    }

    .post-title {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .post-meta {
        font-size: 14px;
        color: #555;
    }

    .post-excerpt {
        font-size: 16px;
        margin-top: 10px;
    }
</style>

<div class="content">
    <main class="main">
        <?php if ( have_posts() ) : ?>

            <!-- Начало цикла вывода постов -->
            <?php while ( have_posts() ) : the_post(); ?>

                <div class="post">
                    <!-- Изображение -->
                    <div class="post-thumbnail">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail( 'medium' ); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Контент -->
                    <div class="post-content">
                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <p class="post-meta">
                            <span class="post-date"><?php echo get_the_date(); ?></span> |
                            <span class="post-author"><?php the_author(); ?></span>
                        </p>

                        <!-- Concept (обрезка текста до 150 символов) -->
                        <div class="post-excerpt">
                            <?php
                            $content = get_the_content();
                            $concept = wp_trim_words( $content, 30, '...' ); // 30 слов - это примерно 150 символов
                            echo $concept;
                            ?>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>

            <!-- Пагинация -->
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
