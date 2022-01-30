<div class="col-3">
    <div class="card mb-3">
        <? the_post_thumbnail() ?>
        <div class="card-body">
            <h5 class="card-title"><? the_title() ?></h5>
            <p>Площадь: <? the_field('square') ?> кв.м.</p>
            <p>Стоимость: <? the_field('price') ?> руб.</p>
            <p>Адрес: <? the_field('address') ?></p>
            <p>Жилая площадь: <? the_field('live_square') ?> кв.м.</p>
            <p>Этаж: <? the_field('floor') ?></p>
            <a href="<? the_permalink() ?>" class="btn btn-primary">Подробнее</a>
        </div>
    </div>
</div>