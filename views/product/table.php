<?php
/**
 * @var array $goods
 */
?>

<link rel="stylesheet" href="/css/productTable.css?t=<?= microtime(true).rand() ?>">

<div class="title">
    <h2 class="title__text">Товары</h2>

    <?php if (count($goods) > 0) :?>
        <a class="button" href="/?c=product&a=create">Добавить товар</a>
    <?php endif; ?>

</div>

<?php if (count($goods) > 0) :?>

    <div class="table">
        <div class="table__row">
            <div class="table__id table__head">ID</div>
            <div class="table__name table__head">Имя</div>
            <div class="table__title table__head">Заголовок</div>
            <div class="table__description table__head">Описание</div>
            <div class="table__image table__head">Изображение</div>
            <div class="table__price table__head">Цена</div>
            <div class="table__control table__head">Управление</div>
        </div>

        <?php foreach ($goods as $product): ?>
            <div class="table__row">
                <div class="table__id"><?= $product->getId(); ?></div>
                <div class="table__name"><?= $product->name; ?></div>
                <div class="table__title"><?= $product->title; ?></div>
                <div class="table__description">
                    <?php echo str_replace(PHP_EOL, '<br>', $product->description); ?>
                </div>
                <div class="table__image">
                    <a href="/?c=product&a=single&id=<?= $product->getId(); ?>">
                        <img src="<?= $product->image; ?>" alt="product">
                    </a>
                </div>
                <div class="table__price"><?= (float)$product->price; ?> &#8381;</div>
                <div class="table__control">
                    <a class="table__link" href="/?c=product&a=update&id=<?= $product->getId() ?>">
                        <i class="fa fa-pencil-square"></i>
                    </a>
                    <a class="table__link table__link_red" href="/?c=product&a=delete&id=<?= $product->getId() ?>">
                        <i class="fa fa-times-circle"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

<?php else :?>

    <p class="message">Товары отсутствуют</p>

<?php endif; ?>
