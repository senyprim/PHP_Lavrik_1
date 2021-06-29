<div class="content">
	<p class="notice"><?= $notice ?></p>
	<a href="add.php">Add article</a>
	<hr>
	<div class="articles">
		<? foreach ($articles as $article) : ?>
			<div class="article">
				<h2><?= $article['title'] ?? ''; ?></h2>
				<a href="article.php?id=<?php echo $article['id'] ?? ''; ?>">Read more</a>
			</div>
		<? endforeach; ?>
	</div>
</div>