<?php
/**
 * @var array $config [action, pageTitle, buttonTitle]
 * @var app\models\Product $product
 */
?>

<link rel="stylesheet" href="/css/productEdit.css?t=<?= microtime(true).rand() ?>">

<div class="title">
    <h2><?= $config['title']; ?></h2>
</div>

<form class="editor" action="<?= $config['action']; ?>"  method="post">

    <?php if ($config['action'] == '/?c=product&a=update') :?>
        <div class="editor__row">
            <label class="editor__label" for="id">ID: </label>
            <input class="editor__edit" type="text" name="id" id="id" value="<?= $product->getId(); ?>" readonly>
        </div>
    <?php endif; ?>

    <div class="editor__row">
        <label class="editor__label" for="name">Название: </label>
        <input class="editor__edit" type="text" name="name" id="name" value="<?= $product->name ?>">
    </div>
    <div class="editor__row">
        <label class="editor__label" for="title">Заголовок: </label>
        <input class="editor__edit" type="text" name="title" id="title" value="<?= $product->title ?>">
    </div>
    <div class="editor__row">
        <label class="editor__label" for="description">Описание: </label>
        <textarea class="editor__memo" name="description" id="description" rows="5"><?=
            $product->description
            ?></textarea>
    </div>
    <div class="editor__row">
        <label class="editor__label" for="image">Изображение: </label>
        <input class="editor__edit" type="text" name="image" id="image" value="<?= $product->image ?>">
    </div>
    <div class="editor__row">
        <label class="editor__label" for="price">Цена: </label>
        <input class="editor__edit" type="text" name="price" id="price" value="<?= $product->price ?>">
    </div>
    <div class="editor__row">
        <label class="editor__label" for="images">Список дополнительных изображений: </label>
        <textarea class="editor__memo" name="images" id="images" rows="5"><?php
            implode('\n', $product->getImagesToString());
            ?></textarea>
    </div>
    <div class="editor__control">
        <input class="button editor__button" type="reset" value="Очистить">
        <input class="button editor__button" type="submit" value="<?= $config['button']; ?>">
    </div>
</form>
