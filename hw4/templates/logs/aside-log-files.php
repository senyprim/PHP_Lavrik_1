<!-- array files (массив иен файлов), active - активный элемент -->
<div class="col-sm">
    <div class="list-group">
        <? foreach ($files as $file) : ?>
            <a href="index.php?c=logs&file=<?= $file ?>" class="list-group-item list-group-item-action <?= $file == $active ? 'disabled' : '' ?>" aria-current="true">
                <?=$file;?>
            </a>

        <? endforeach ?>
    </div>
</div>