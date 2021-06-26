<?php

include_once __DIR__ . '/constants.php';
include_once BASE_DIR . '/classes/ArticleRepository.php';
include_once BASE_DIR . '/classes/Db.php';
include_once BASE_DIR . '/models/Article.php';

$repository = new ArticleRepository(new Db());
$result=false;
$article=null;

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $id = ($_GET['id'] ?? '');
	$result=$repository->checkId($id);
	if ($result) {
        $article = $repository->getArticle($id);
    }
}
?>

<div class="content">
	<? if ($result) : ?>
		<div class="article">
			<h1><?=$article->getTitle()?></h1>
			<p>Author:<?=$article->getAuthor()?></p>
			<div><?=$article->getContent()?></div>
			<hr>
			<a href="delete.php?id=<?=$article->getId()?>">Remove</a>
			<a href="edit.php?id=<?=$article->getId()?>">Edit</a>
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
