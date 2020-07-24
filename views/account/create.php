<?php
/**
 * @var string $styles
 */
?>

<?= $styles; ?>

<main class="container">

<h2 class="account__title">Создание аккаунта</h2>

<form class="account__form" method="post">
    <span>
        <label class="account__label" for="name">Имя: </label>
        <input class="account__edit" type="text" name="name" id="name"
               placeholder="Введите имя" required>
    </span>
    <span>
        <label class="account__label" for="email">Email: </label>
        <input class="account__edit" type="email" name="email" id="email"
               placeholder="Введите email" required>
    </span>
    <span>
        <label class="account__label" for="password">Пароль: </label>
        <input class="account__edit" type="password" name="password" id="password"
               placeholder="Введите пароль" required>
    </span>
    <div class="account__control">
        <button class="account__button" type="submit">Создать</button>
    </div>
</form>

</main>
