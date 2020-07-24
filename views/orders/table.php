<?php
/**
 * @var string $styles
 * @var array $statuses
 * @var array $orders
 * @var bool $noOrders
 */
?>

<?= $styles; ?>

<main class="container">

<div class="page__title">
    <h2>Заказы</h2>
</div>

<?php if (!$noOrders) :?>

<table class="table-orders">
    <tr>
        <th class="table-orders__col1">ID</th>
        <th class="table-orders__col2">Пользователь</th>
        <th class="table-orders__col3">Количество товаров</th>
        <th class="table-orders__col4">Общая стоимость</th>
        <th class="table-orders__col5">Статус</th>
        <th class="table-orders__col6">Управление</th>
    </tr>

    <?php foreach ($orders as $order): ?>

    <tr><form class="part-content" id="form-<?= $order['order'] ?>">
        <td class="table-orders__col1"><?= $order['order']; ?></td>
        <td class="table-orders__col2"><span class="part-content"><?= $order['user']; ?></span></td>
        <td class="table-orders__col3"><span class="part-content"><?= (float)$order['quantity']; ?></span></td>
        <td class="table-orders__col4"><span class="part-content"><?= (float)$order['cost']; ?> &#8381;</span></td>
        <td class="table-orders__col5">
            <input type="hidden" form="form-<?= $order['order'] ?>" name="p" value="orders">
            <input type="hidden" form="form-<?= $order['order'] ?>" name="a" value="change">
            <input type="hidden" form="form-<?= $order['order'] ?>" name="id" value="<?= $order['order'] ?>">
            <span>
                <select name="status" form="form-<?= $order['order'] ?>" required>
                    <?php foreach($statuses as $status) :?>
                        <?php if ($status == $order['status']) :?>
                            <option value="<?= $status; ?>" selected><?= $status; ?></option>
                        <?php else :?>
                            <option value="<?= $status; ?>"><?= $status; ?></option>
                        <?php endif ?>
                    <?php endforeach; ?>
                </select>
            </span>
        </td>
        <td class="table-orders__col6">
            <button class="table-orders__button" type="submit" form="form-<?= $order['order'] ?>">
                <i class="fa fa-refresh"></i>
            </button>
        </td>
    </form></tr>

    <?php endforeach; ?>

</table>

<?php else :?>

<p class="page__message">Заказы отсутствуют</p>

<?php endif; ?>

</main>
