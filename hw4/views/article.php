<div class="content">
    <p class="notice"><?=$notice?></p>
    <div class="article">
        <h1><?= $fields['title'] ?? '' ?></h1>
        <p>Category:<?= $fields['category'] ?? '' ?></p>
        <div><?= $fields['content'] ?? '' ?></div>
        <hr>
        <form action="delete.php" method="post">
            <input type="hidden" name="id" value=<?= $fields['id'] ?>>
            <a href="edit.php?id=<?= $fields['id'] ?? '' ?>">Edit</a>
            <button type="submit" style="border:none; background:none;text-decoration:underline;cursor:pointer;">Remove</a>
        </form>
        </form>
    </div>
    <hr>
    <a href="index.php">Move to main page</a>
</div>