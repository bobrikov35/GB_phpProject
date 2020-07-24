<?php
/**
 * @var string $styles
 * @var array $orderList
 * @var bool $noOrders
 */
?>

<?= $styles; ?>

<main class="container">

<div class="page__title">
    <h2>Заказы</h2>
</div>

<?php if (!$noOrders) :?>

<table class="table">
    <tr class="table__header">
        <th class="table__column">Номер заказа</th>
        <th class="table__column">Позиции</th>
        <th class="table__column">Количество</th>
        <th class="table__column">Общая стоимость</th>
        <th class="table__column">Статус</th>
        <th class="table__column">Действия</th>
    </tr>

    <?php foreach ($orderList as $order): ?>

    <tr>
        <td class="table__column"><?= $order['order']; ?></td>
        <td class="table__column"><?= $order['count']; ?></td>
        <td class="table__column"><?= $order['quantity']; ?></td>
        <td class="table__column table__price"><?= (float)$order['cost']; ?> &#8381;</td>
        <td class="table__column table__status"><?= $order['status']; ?></td>
        <td class="table__column">
            <div class="table__control">
                <a class="table__link" href="/?p=orders&a=view&id=<?= $order['order'] ?>">
                    <i class="fa fa-list-alt"></i>
                </a>
                <a class="table__link table__link_red" href="/?p=orders&a=cancel&id=<?= $order['order'] ?>">
                    <i class="fa fa-times-circle"></i>
                </a>
            </div>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

<?php else :?>

<p class="page__message">Заказы отсутствуют</p>

<?php endif; ?>

</main>
