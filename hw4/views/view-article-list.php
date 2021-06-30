<div class="content">
	<p class="notice"><?= $notice ?></p>
	<a href="index.php?c=add">Add article</a>
	<hr>
	<div class="articles">
		<? foreach ($articles as $article) : ?>
			<div class="article">
				<h2><?= $article['title'] ?? ''; ?></h2>
				<a href="index.php?c=article&id=<?php echo $article['id'] ?? ''; ?>">Read more</a>
			</div>
		<? endforeach; ?>
	</div>
</div>