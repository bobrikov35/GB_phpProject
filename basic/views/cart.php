<?php
/**
 * @var string $styles
 * @var array $cartItems
 * @var bool $cartEmpty
 */
?>

<?= $styles; ?>

<main class="container">

<div class="page__title">
    <h2>Корзина</h2>

<?php if (!$cartEmpty) :?>

    <a href="/?p=orders&a=make">Заказать</a>

<?php endif; ?>

</div>

<?php if (!$cartEmpty) :?>

<table class="table">
    <tr class="table__header">
        <th>Продукт</th>
        <th>Цена</th>
        <th>Количество</th>
        <th>Общая стоимость</th>
        <th>Действия</th>
    </tr>

    <?php foreach ($cartItems as $product) :?>

    <tr>
        <td class="product-cart">
            <a class="product-cart__picture" href="/?p=product&id=<?= $product['id']; ?>">
                <img src="<?= $product['image']; ?>" alt="product">
            </a>
            <div class="product-cart__content">
                <h3 class="product-cart__title"><?= $product["title"]; ?></h3>
            </div>
        </td>
        <td class="table__price"><?= (float)$product['price']; ?> &#8381;</td>
        <td class="table__quantity"><?= $product['quantity']; ?></td>
        <td class="table__price"><?= $product['price'] * $product['quantity']; ?> &#8381;</td>
        <td>
            <div class="table__control">
                <a class="table__link" href="/?p=cart&a=add&id=<?= $product['id']; ?>">+1</a>
                <a class="table__link" href="/?p=cart&a=remove&id=<?= $product['id']; ?>">-1</a>
                <a class="table__link table__link_all" href="/?p=cart&a=removeAll&id=<?= $product['id']; ?>">Удалить</a>
            </div>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

<?php else :?>

<p class="page__message">В корзине нет товаров</p>

<?php endif; ?>

</main>
