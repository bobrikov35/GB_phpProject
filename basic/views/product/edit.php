<?php
/**
 * @var string $styles
 * @var string $title
 * @var array $page
 * @var array $data
 */
?>

<?= $styles; ?>

<main class="container">

    <h1 class="editor__title"><?= $title; ?></h1>

    <form class="editor__form" action="<?= $page['action']; ?>"  method="post">
        <span>
            <?php if (isset($page['id'])) :?>
            <label class="editor__label" for="id">ID: </label>
            <h3 class="editor__id" id="id"><?= $page['id']; ?></h3>
            <?php endif; ?>
        </span>
        <span>
            <label class="editor__label" for="name">Название: </label>
            <input class="editor__edit" type="text" name="name" id="name" required
                   <?php if (isset($data['name'])) echo "value=\"{$data['name']}\""; ?>>
        </span>
        <span>
            <label class="editor__label" for="title">Заголовок: </label>
            <input class="editor__edit" type="text" name="title" id="title" required
                   <?php if (isset($data['title'])) echo "value=\"{$data['title']}\""; ?>>
        </span>
        <span>
            <label class="editor__label" for="description">Описание: </label>
            <textarea class="editor__memo" name="description" id="description" required
                      rows="5"><?php if (isset($data['description'])) echo "{$data['description']}"; ?></textarea>
        </span>
        <span>
            <label class="editor__label" for="image">Изображение: </label>
            <input class="editor__edit" type="text" name="image" id="image" required
                   <?php if (isset($data['image'])) echo "value=\"{$data['image']}\""; ?>>
        </span>
        <span>
            <label class="editor__label" for="price">Цена: </label>
            <input class="editor__edit" type="text" name="price" id="price" required
                   <?php if (isset($data['price'])) echo "value=\"{$data['price']}\""; ?>>
        </span>
        <span>
            <label class="editor__label" for="images">Список дополнительных изображений: </label>
            <textarea class="editor__memo" name="images" id="images"
                      rows="5"><?php if (isset($data['images'])) echo "{$data['images']}"; ?></textarea>
        </span>
        <div class="editor__control">
            <button class="editor__button" type="submit"><?= $page['button']; ?></button>
        </div>
    </form>

</main>