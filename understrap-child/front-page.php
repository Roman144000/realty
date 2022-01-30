<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();

$container = get_theme_mod('understrap_container_type');

$realty = get_posts([
    'numberposts' => 4,
    'orderby'     => 'date',
    'order'       => 'DESC',
    'post_type'   => 'realty',
]);

$city = get_posts([
    'numberposts' => 4,
    'orderby'     => 'date',
    'order'       => 'DESC',
    'post_type'   => 'city',
]);
?>

<?php if (is_front_page() && is_home()) : ?>
    <?php get_template_part('global-templates/hero'); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

    <div class="<?php echo esc_attr($container); ?>" id="content" tabindex="-1">

        <h2 class="mt-5">Недвижимость</h2>

        <div class="row mt-3">
            <? foreach ($realty as $post) {
                setup_postdata($post); ?>
                <?php get_template_part('global-templates/realty-loop'); ?>
            <? }
            wp_reset_postdata(); ?>

        </div><!-- .row -->

        <h2 class="mt-5">Города</h2>

        <div class="row mt-3">
            <? foreach ($city as $post) {
                setup_postdata($post);
                get_template_part('global-templates/city-loop');
            }
            wp_reset_postdata(); ?>

        </div><!-- .row -->

        <h3 class="mt-5">Форма для добавления недвижимости</h3>

        <?
        $all_city = get_posts([
            'numberposts' => -1,
            'post_type'   => 'city',
        ]);
        $categories = get_terms([
            'hide_empty'  => 0,
            'taxonomy'    => 'type_realty',
        ]);
        ?>
        <form class="form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="inputAddress">Адрес</label>
                <input require type="text" class="form-control" id="inputAddress" name="address" placeholder="Введите адрес">
            </div>
            <div class="form-group">
                <label for="inputSquare">Площадь</label>
                <input require type="number" class="form-control" id="inputSquare" name="square" placeholder="Введите площадь">
            </div>
            <div class="form-group">
                <label for="inputPrice">Стоимость</label>
                <input require type="number" class="form-control" id="inputPrice" name="price" placeholder="Введите стоимость">
            </div>
            <div class="form-group">
                <label for="inputLiveSquare">Жилая площадь</label>
                <input require type="number" class="form-control" id="inputLiveSquare" name="liveSquare" placeholder="Введите жилую площадь">
            </div>
            <div class="form-group">
                <label for="inputFloor">Этаж</label>
                <input require type="number" class="form-control" id="inputFloor" name="floor" placeholder="Введите этаж">
            </div>
            <div class="form-group">
                <label for="inputImg">Изображение</label>
                <input require type="file" class="form-control-file" id="inputImg" name="image" placeholder="Загрузите изображение">
            </div>
            <div class="form-group">
                <label for="inputCity">Выберите город</label>
                <select require class="form-control" id="inputCity" name="city">
                    <option disabled selected>Выберите город</option>
                    <?
                    foreach ($all_city as $post) {
                        setup_postdata($post); ?>
                        <option value=<? the_ID() ?>><? the_title() ?></option>
                    <? }
                    wp_reset_postdata();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="inputCategory">Выберите категорию</label>
                <select require class="form-control" id="inputCategory" name="category">
                    <option disabled selected>Выберите категорию</option>
                    <?
                    foreach ($categories as $category) { ?>
                        <option value=<?= $category->slug ?>><?= $category->name ?></option>
                    <? }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Создать</button>
        </form>

    </div><!-- #content -->

</div><!-- #index-wrapper -->

<?php
get_footer();
