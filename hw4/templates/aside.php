<? $disabled = $id ? '' : 'disabled'; ?>
<div class="col-sm">
    <div class="list-group">
        <a href="index.php?c=edit&id=<?= $id ?>" class="list-group-item list-group-item-action <?= $disabled ?>" aria-current="true">
            Edit
        </a>
        <form method="post" action="index.php?c=delete">
            <input type="hidden" name="id" value="<?= $id ?>">
            <button class="list-group-item list-group-item-action  <?= $disabled ?>">Delete</button>
        </form>
    </div>
</div>