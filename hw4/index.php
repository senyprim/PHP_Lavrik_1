<?php
	include_once __DIR__.'/constants.php';

	include_once BASE_DIR.'/classes/Db.php';
	include_once BASE_DIR.'/classes/ArticleRepository.php';

	$repository=new ArticleRepository(new Db());
	$articles = $repository->getAll();//Берем статьи с базы
	$notice=$_GET['notice']??'';
?>
<p><?php echo $notice ?></p>
<a href="add.php">Add article</a>
<hr>
<div class="articles">
	<? foreach($articles as $article): ?>
		<div class="article">
			<h2><?=$article->getTitle()?></h2>
			<a href="article.php?id=<?=$article->getId()?>">Read more</a>
		</div>
	<? endforeach; ?>
</div>
	