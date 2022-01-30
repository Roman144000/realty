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
        <?
        $childrens_realty = get_children([
            'post_parent' => get_the_ID(),
            'post_type'   => 'realty',
            'numberposts' => 10,
        ]);
        ?>
        <div class="row">
            <?
            if ($childrens_realty) {
                foreach ($childrens_realty as $post) {
                    setup_postdata($post);
                    get_template_part('global-templates/realty-loop');
                }
                wp_reset_postdata();
            }
            ?>
        </div>


    </div><!-- .entry-content -->

    <footer class="entry-footer">

        <?php understrap_entry_footer(); ?>

    </footer><!-- .entry-footer -->

</article><!-- #post-## -->