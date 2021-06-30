<div class="content">
    <h1><?= $titleView ?></h1>
    <ol>
        <?php foreach ($files as $file) : ?>
            <li><a href="index.php?c=log&file=<?= $file ?>"><?= $file ?></a></li>
        <? endforeach ?>
    </ol>
    <br>
    <br>
    <a href="index.php">Вернутся на главную страницу</a>
</div>