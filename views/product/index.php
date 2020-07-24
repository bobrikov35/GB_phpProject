<?php
/**
 * @var array $goods
 */
?>

<link rel="stylesheet" href="/css/product.css?t=<?= microtime(true).rand() ?>">

<div class="title">
    <h2 class="title__text">Каталог товаров</h2>
</div>

<?php if (count($goods) > 0) :?>

    <div class="content">

        <?php foreach ($goods as $product) :?>
            <div class="product">
                <a class="product__image" href="/?c=product&a=single&id=<?= $product->getId(); ?>">
                    <img src="<?= $product->image; ?>" alt="product">
                </a>
                <h3 class="product__name"><?= $product->title; ?></h3>
                <p class="product__text">
                    <?php echo str_replace(PHP_EOL, '<br>', $product->description); ?>
                </p>
                <p class="product__price">Цена: <?= (float)$product->price; ?> &#8381;</p>
                <a class="button product__link" href="/?c=cart&a=add&id=<?= $product->getId(); ?>">
                    Добавить в корзину
                </a>
            </div>

        <?php endforeach; ?>

    </div>

<?php else :?>

<p class="message">Товары отсутствуют</p>

<?php endif; ?>
