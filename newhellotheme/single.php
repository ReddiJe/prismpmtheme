<?php get_header(); ?>

<style>
    .single-post-container .single-post {
        padding: 50px 10%;
    }

    .single-post-container .single-post h1 {
        margin-bottom: 20px;
    }

    .single-post-container .single-post .post-thumbnail {
        position: relative; /* Для размещения элементов поверх изображения */
        margin-bottom: 40px;
    }

    .single-post-container .single-post .post-thumbnail img {
        width: 100%;
        height: 500px;
        display: block; /* Убираем отступы для изображений */
    }

    .single-post-container .single-post .post-meta {
        position: absolute; /* Абсолютное позиционирование */
        bottom: 10px; /* Расстояние от нижнего края изображения */
        left: 10px; /* Расстояние от левого края изображения */
        background: rgba(0, 0, 0, 0.6); /* Полупрозрачный чёрный фон */
        color: #fff; /* Белый текст */
        font-size: 14px;
        padding: 10px 15px;
        border-radius: 5px;
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
                            <span>Posted: <?php the_date(); ?></span><br>
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
