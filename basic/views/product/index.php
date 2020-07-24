<?php
/**
 * @var string $styles
 * @var array $product
 * @var array $images
 * @var array $feedbacks
 */
?>

<?= $styles ?>

<main class="container">

<div class="product">
    <div class="product__picture" data-img="0" onclick="imgClick(this)">

<?php if (count($images) > 0) :?>
    <?php foreach ($images as $key => $image) :?>

        <img src="<?= $image['link']; ?>" id="img-<?= $key; ?>"

        <?php if ($key > 0) echo ' style="display: none;"'; ?> alt="product">
    <?php endforeach; ?>
<?php else :?>

        <img src="<?= $product['image']; ?>" id="img-0" alt="product">

<?php endif; ?>

    </div>
    <div class="product__content">
        <h1 class="product__name"><?= $product['title']; ?></h1>
        <p class="product__desc"><?= $product['description']; ?></p>
        <p class="product__price">Цена: <?= (float)$product['price']; ?> &#8381;</p>
        <div class="product__control">
            <a class="product__link"  href="/?p=cart&a=add&id=<?= $product['id']; ?>">Добавить в корзину</a>
            <a class="product__link" href="/?p=feedback&id=<?= $product['id']; ?>">Оставить отзыв</a>
        </div>
    </div>
</div>
<div class="feedback">
    <h2 class="feedback__title">Отзывы</h2>

<?php if (count($feedbacks) > 0) :?>
    <?php foreach ($feedbacks as $feedback) :?>

    <div class="feedback__block">
        <h3 class="feedback__name"><?= $feedback['name'] ?> &nbsp; &lt; <?= $feedback['email'] ?> &gt;</h3>
        <hr>
        <p class="feedback__text"><?= $feedback['comment'] ?></p>
    </div>

    <?php endforeach; ?>
<?php else: ?>

    <h3 class="feedback__name">Отзывов нет</h3>

<?php endif; ?>

</div>

</main>

<script src="/js/product.js"></script>
