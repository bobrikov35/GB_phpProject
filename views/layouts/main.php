<?php
/**
 * @var string $title
 * @var array $menu
 * @var string $content
 */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/index.css?t=<?= microtime(true).rand(); ?>">
    <title>BRAND: <?= $title ?></title>
</head>
<body>

<div id="app">

    <header class="header">
        <div class="header__container">
            <a class="logo" href="/?c=home">
                <img src="/images/origami-logo.svg" width="50px" height="50px" alt="logo">
                <h2 class="logo__title">Brand</h2>
            </a>
            <nav class="menu">
                <?php foreach ($menu as $item) :?>
                <a class="menu__item" href="<?= $item['link']; ?>"><?= $item['name']; ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
    </header>

    <main>
        <?= $content ?>
    </main>

    <footer class="footer">
        <div class="footer__container">
            <div class="footer__contacts">
                <div class="footer__contact">
                    <img src="/images/envelope.svg" width="40px" height="40px" alt="icon">
                    <p class="footer__text">info@brandshop.ru</p>
                </div>
                <div class="footer__contact">
                    <img src="/images/phone-call.svg" width="40px" height="40px" alt="icon">
                    <p class="footer__text">8 (800) 555-00-00</p>
                </div>
                <div class="footer__contact">
                    <img src="/images/placeholder.svg" width="40px" height="40px" alt="icon">
                    <p class="footer__text">Москва, пр-т Ленина, д. 1 офис 304</p>
                </div>
            </div>
            <nav class="footer__nav">
                <a class="footer__links" href="/?c=home">Главная</a>
                <a class="footer__links" href="/?c=product&a=list">Товары</a>
            </nav>
        </div>
    </footer>

    <footer class="links">
        <div class="links__container">
            <div class="links__social">
                <img class="links__item"
                     src="/images/vk-social-logotype.svg" width="40px" height="40px" alt="vk">
                <img class="links__item"
                     src="/images/google-plus-social-logotype.svg" width="40px" height="40px" alt="g+">
                <img class="links__item"
                     src="/images/facebook-logo.svg" width="40px" height="40px" alt="fb">
            </div>
            <p class="links__copyright">&copy; Brand</p>
        </div>
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/vue"></script>-->
<script src="/js/product.js"></script>

</body>
</html>