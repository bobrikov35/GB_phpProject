<?php
/**
 * @var string $styles
 * @var array $goods
 * @var bool $noGoods
 */
?>

<?= $styles ?>

<main class="container">

<div class="page__title">
    <h2>Каталог товаров</h2>
</div>

<?php if (!$noGoods) :?>

<div class="page">

    <?php foreach ($goods as $product) :?>

    <div class="product-shop">
        <a class="product-shop__picture" href="/?p=product&id=<?= $product['id']; ?>">
            <img src="<?= $product["image"]; ?>" alt="product">
        </a>
        <h3 class="product-shop__name"><?= $product["title"]; ?></h3>
        <p class="product-shop__text"><?= $product["description"]; ?></p>
        <p class="product-shop__price">Цена: <?= (float)$product["price"]; ?> &#8381;</p>
        <a class="product-shop__link" href="/?p=cart&a=add&id=<?= $product['id']; ?>">Добавить в корзину</a>
    </div>

    <?php endforeach; ?>

</div>

<?php else :?>

<p class="page__message">Товары отсутствуют</p>

<?php endif; ?>

</main>
