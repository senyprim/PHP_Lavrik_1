<?php

include_once __DIR__ . '/models/article.php';
include_once __DIR__ . '/models/logs.php';
addLog();
$articles = getArticles();

$id = (int) ($_GET['id'] ?? '');
$notice = ($_GET['notice'] ?? '');
$post = $articles[$id] ?? null;
$hasPost = ($post !== null);

?>
<div class="content">
	<p> <?php echo $notice ?></p>
	<? if ($hasPost) : ?>
		<div class="article">
			<h1><?=$post['title']?></h1>
			<div><?=$post['content']?></div>
			<hr>
			<a href="delete.php?id=<?=$id?>">Remove</a>
			<a href="edit.php?id=<?=$id?>">Edit</a>
			</form>
		</div>
	<? else : ?>
		<div class="e404">
			<h1>Страница не найдена!</h1>
		</div>
	<? endif; ?>
</div>
<hr>
<a href="index.php">Move to main page</a>