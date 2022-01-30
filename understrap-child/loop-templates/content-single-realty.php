<?php

/**
 * Single city post partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

    <header class="entry-header">

        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

        <div class="entry-meta">

            <?php understrap_posted_on(); ?>

        </div><!-- .entry-meta -->

    </header><!-- .entry-header -->

    <?php echo get_the_post_thumbnail($post->ID, 'large'); ?>

    <div class="entry-content">

        <?php
        the_content();
        understrap_link_pages();
        ?>
        
        <p>Площадь: <? the_field('square') ?> кв.м.</p>
        <p>Стоимость: <? the_field('price') ?> руб.</p>
        <p>Адрес: <? the_field('address') ?></p>
        <p>Жилая площадь: <? the_field('live_square') ?> кв.м.</p>
        <p>Этаж: <? the_field('floor') ?></p>


    </div><!-- .entry-content -->

    <footer class="entry-footer">

        <?php understrap_entry_footer(); ?>

    </footer><!-- .entry-footer -->

</article><!-- #post-## -->