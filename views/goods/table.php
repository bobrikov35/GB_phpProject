<?php
/**
 * @var string $styles
 * @var array $goods
 * @var bool $noGoods
 */
?>

<?= $styles; ?>

<main class="container">

<div class="page__title">
    <h2>Товары</h2>

<?php if (!$noGoods) :?>

    <a href="/?p=product&a=insert">Добавить товар</a>

<?php endif; ?>

</div>

<?php if (!$noGoods) :?>

<table class="table">
    <tr>
        <th class="table__col1">ID</th>
        <th class="table__col2">Имя</th>
        <th class="table__col3">Заголовок</th>
        <th class="table__col4">Описание</th>
        <th class="table__col5">Изображение</th>
        <th class="table__col6">Цена</th>
        <th class="table__col7">Управление</th>
    </tr>

    <?php foreach ($goods as $product): ?>

    <tr>
        <td class="table__col1"><?= $product['id']; ?></td>
        <td class="table__col2"><span class="part-content"><?= $product['name']; ?></span></td>
        <td class="table__col3"><span class="part-content"><?= $product['title']; ?></span></td>
        <td class="table__col4"><span class="part-content"><?= $product['description']; ?></span></td>
        <td class="table__col5"><span class="part-content"><?= $product['image']; ?></span></td>
        <td class="table__col6"><?= (float)$product['price']; ?></td>
        <td class="table__col7">
            <a class="table__link" href="/?p=product&a=update&id=<?= $product['id'] ?>">
                <i class="fa fa-pencil-square"></i>
            </a>
            <a class="table__link table__link_red" href="/?p=product&a=delete&id=<?= $product['id'] ?>">
                <i class="fa fa-times-circle"></i>
            </a>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

<?php else :?>

<p class="page__message">Товары отсутствуют</p>

<?php endif; ?>

</main>
