<?php
	include_once(__DIR__.'/models/article.php');
	include_once(__DIR__.'/models/logs.php');
	addLog();
	$articles = getArticles();
	$notice=$_GET['notice']??'';
?>
<p><?php echo $notice ?></p>
<a href="add.php">Add article</a>
<hr>
<div class="articles">
	<? foreach($articles as $id => $article): ?>
		<div class="article">
			<h2><?=$article['title']?></h2>
			<a href="article.php?id=<?=$id?>">Read more</a>
		</div>
	<? endforeach; ?>
</div>
	