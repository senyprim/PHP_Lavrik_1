<?php

include_once __DIR__ . '/constants.php';
include_once BASE_DIR . '/classes/ArticleRepository.php';
include_once BASE_DIR . '/classes/Db.php';
include_once BASE_DIR . '/models/Article.php';
include_once BASE_DIR . '/Repository.php';
include_once (BASE_DIR.'/models/logs.php');
addLog();

$repository = new ArticleRepository(new Db());
$article=null;

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $id = ($_GET['id'] ?? '');
	if (checkId($id)) {
        $article = $repository->getArticle($id);
    }
}
?>

<div class="content">
	<? if ($article) : ?>
		<div class="article">
			<h1><?=$article['title']??''?></h1>
			<p>Category:<?=$article['category']??''?></p>
			<div><?=$article['content']??''?></div>
			<hr>
			<form action="delete.php" method="post">
				<input type="hidden" name="id" value=<?=$article['id']?>>
				<a href="edit.php?id=<?=$article['id']??''?>">Edit</a>
				<button type="submit" style="border:none; background:none;text-decoration:underline;cursor:pointer;">Remove</a>
			</form>
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
