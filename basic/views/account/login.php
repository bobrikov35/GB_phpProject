<?php
/**
 * @var string $styles
 */
?>

<?= $styles; ?>

<main class="container">

    <h2 class="account__title">Вход в аккаунт</h2>
    <form class="account__form" method="post">
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
            <button class="account__button" type="submit">Войти</button>
            <a class="account__link" href="/?p=account&a=create">Создать аккаунт</a>
        </div>
    </form>

</main>
