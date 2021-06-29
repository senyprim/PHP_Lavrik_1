<?php
include_once __DIR__ . '/constants.php';
include_once BASE_DIR . '/models/article.php';
include_once BASE_DIR . '/models/category.php';
include_once BASE_DIR . '/models/logs.php';
addLog();


$articles = getAllArticle(); //Берем статьи с базы
?>
<a href="add.php">Add article</a>
<hr>
<div class="articles">
	<? foreach($articles as $article): ?>
		<div class="article">
			<h2><?=$article['title'] ?? '';?></h2>
			<a href="article.php?id=<?php echo $article['id'] ?? ''; ?>">Read more</a>
		</div>
	<? endforeach; ?>
</div>
