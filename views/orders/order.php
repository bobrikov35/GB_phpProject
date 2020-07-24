<?php
/**
 * @var string $styles
 * @var array $goods
 */
?>

<?= $styles; ?>

<main class="container">

<div class="page__title">
    <h2>Заказ №<?= $goods[0]['order']; ?></h2>
</div>

<table class="table-goods">
    <tr class="table-goods__header">
        <th>Продукт</th>
        <th>Цена</th>
        <th>Количество</th>
        <th>Общая стоимость</th>
    </tr>

<?php foreach ($goods as $product) :?>

    <tr>
        <td class="product-order">
            <a class="product-order__picture" href="/?p=product&id=<?= $product['product']; ?>">
                <img src="<?= $product['image']; ?>" alt="product">
            </a>
            <div class="product-order__content">
                <h3 class="product-order__title"><?= $product["title"]; ?></h3>
            </div>
        </td>
        <td class="table-goods__price"><?= (float)$product['price']; ?> &#8381;</td>
        <td class="table-goods__quantity"><?= (int)$product['quantity']; ?></td>
        <td class="table-goods__price"><?= $product['price'] * $product['quantity']; ?> &#8381;</td>
    </tr>

<?php endforeach; ?>

</table>

</main>
