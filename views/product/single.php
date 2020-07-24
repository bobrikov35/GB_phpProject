<?php
/**
 * @var app\models\Product $product
 */
?>

<link rel="stylesheet" href="/css/productSingle.css?t=<?= microtime(true).rand() ?>">

<div class="product">
    <div class="product__image" data-img="0" onclick="imgClick(this)">

        <?php if (count($product->getImages()) > 0) :?>

            <?php foreach ($product->getImages() as $key => $image) :?>
                <img src="<?= $image; ?>" id="img-<?= $key; ?>"
                    <?php if ($key > 0) echo ' style="display: none;"'; ?> alt="product">
            <?php endforeach; ?>

        <?php else :?>

            <img src="<?= $product->image; ?>" id="img-0" alt="product">

        <?php endif; ?>

    </div>

    <div class="product__content">
        <h2 class="product__name"><?= $product->title; ?></h2>
        <p class="product__description">
            <?php
            if (isset($product->description)) {
                echo str_replace(PHP_EOL, '<br>', $product->description);
            }
            ?>
        </p>
        <p class="product__price">Цена: <?= (float)$product->price; ?> &#8381;</p>
        <div class="product__control">
            <a class="button product__button"  href="/?c=cart&a=add&id=<?= $product->getId(); ?>">Добавить в корзину</a>
            <a class="button product__button" href="/?c=feedback&id=<?= $product->getId(); ?>">Оставить отзыв</a>
        </div>
    </div>
</div>

<div class="feedback">
    <h3 class="feedback__title">Отзывы</h3>

    <?php if (count($product->getFeedbacks()) > 0) :?>

        <?php foreach ($product->getFeedbacks() as $feedback) :?>
            <div class="feedback__block">
                <h4 class="feedback__name"><?= $feedback['name'] ?> &nbsp; &lt;&lt; <?= $feedback['email'] ?> &gt;&gt;</h4>
                <hr>
                <p class="feedback__comment"><?= $feedback['comment'] ?></p>
            </div>
        <?php endforeach; ?>

    <?php else: ?>

        <h4 class="feedback__name">Отзывов нет</h4>

    <?php endif; ?>

</div>

<script src="/js/product.js"></script>
