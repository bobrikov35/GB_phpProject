<?php
/**
 * @var string $styles
 * @var bool $admin
 */
?>

<?= $styles; ?>

<main class="container">

    <h2 class="account__title"><span><?= $_SESSION['user']['name'] ?></span>, добро пожаловать в магазин!</h2>
    <p class="account__text">Ваш логин: <span><?= $_SESSION['user']['email'] ?></span></p>
    <p class="account__text">Права администратора: <span><?= $admin ?></span></p>

</main>
