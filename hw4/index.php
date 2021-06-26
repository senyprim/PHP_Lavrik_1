<?php
	include_once __DIR__.'/constants.php';

	include_once BASE_DIR.'/classes/Db.php';
	include_once BASE_DIR.'/classes/ArticleRepository.php';

	$repository=new ArticleRepository(new Db());
	$articles = $repository->getAll();//Берем статьи с базы
	$notice=$_GET['notice']??'';
?>
<p><?=$notice ?></p>
<a href="add.php">Add article</a>
<hr>
<div class="articles">
	<? foreach($articles as $article): ?>
		<div class="article">
			<h2><?=$article->getTitle()?></h2>
			<a href="article.php?id=<?php echo $article->getId()?>">Read more</a>
		</div>
	<? endforeach; ?>
</div>
	