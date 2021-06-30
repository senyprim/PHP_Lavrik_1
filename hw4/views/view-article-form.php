<form action=<?="index.php?c=$action"?> method="post">
    <h1><?=$titleForm?></h1>
    <input type="hidden" name="id" value="<?=$fields['id']??''?>">
    Title :<input type="text" name="title" value="<?php echo $fields['title']; ?>" placeholder="Введите заголовок статьи">
    <br>
    <br>

    Category :
    <select name="id_category" placeholder="Введите текст статьи">
        <option value="" disabled selected>Выберите категорию статьи</option>
        <?php foreach ($categories as $category) : ?>
            <option value="<?php echo $category['id'] ?? '' ?>" <?php echo $category['id'] == $fields['id_category'] ? 'selected' : '' ?>>
                <?php echo $category['name'] ?? ''; ?>
            </option>
        <? endforeach; ?>
    </select>
    <br>
    <br>

    Content :<textarea name="content" placeholder="Введите текст статьи"><?php echo $fields['content'] ?></textarea>
    <br>
    <br>
    <button><?=$buttonForm?></button>
    <!-- Показать ошибки -->
    <?php if (!!$errors) : ?>
        <div class="errors">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error ?></p>
            <?php endforeach ?>
        </div>
    <? endif ?>
</form>
<hr>
<a href="index.php">Move to main page</a>